<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="description" content="Deskripsi Blog">
<meta name="author" content="Judul Blog">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="omfgitsasalmon">
<meta name="twitter:title" content="Simple Blog">
<meta name="twitter:description" content="Deskripsi Blog">
<meta name="twitter:creator" content="Simple Blog">
<meta name="twitter:image:src" content="{{! TODO: ADD GRAVATAR URL HERE }}">

<meta property="og:type" content="article">
<meta property="og:title" content="Simple Blog">
<meta property="og:description" content="Deskripsi Blog">
<meta property="og:image" content="{{! TODO: ADD GRAVATAR URL HERE }}">
<meta property="og:site_name" content="Simple Blog">

<link rel="stylesheet" type="text/css" href="assets/css/screen.css" />
<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">

<!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<title>Simple Blog | Apa itu Simple Blog?</title>


</head>

<body class="default">
<div class="wrapper">

<nav class="nav">
    <a style="border:none;" id="logo" href="index.php"><h1>Simple<span>-</span>Blog</h1></a>
    <ul class="nav-primary">
        <li><a href="new_post.php">+ Tambah Post</a></li>
    </ul>
</nav>

<article class="art simple post">
    
	<?php 
		require 'dbinit.php';
		$Post_ID = $_GET["Post_ID"];
		$Judul;
		$Tanggal;
		$Konten;
		$dbhost = 'localhost';
		$dbuser = 'root';
		$dbpass = '';
		$conn = mysql_connect($dbhost, $dbuser, $dbpass);
		if(! $conn )
		{
			die('Could not connect: ' . mysql_error());
		}
		$sql = "SELECT * FROM posts WHERE post_id = $Post_ID";

		mysql_select_db('simple_blog_db');
		$retval = mysql_query( $sql, $conn );
		if(! $retval )
		{
			die('Could not get data: ' . mysql_error());
		}
		$row = mysql_fetch_array($retval);
		$Judul = $row['post_title'];
		$Tanggal = $row['post_date'];
		$Konten = $row['post_content'];
		
		mysql_close($conn);
		
		$Nama; 
		$Email; 
		$Komentar;
		if(isset($_POST["Nama"])||isset($_POST["Email"])||isset($_POST["Komentar"])){
			$Nama = $_POST["Nama"];
			$Email = $_POST["Email"];
			$Komentar = $_POST["Komentar"];
			
			$dbhost = 'localhost';
			$dbuser = 'root';
			$dbpass = '';
			$conn = mysql_connect($dbhost, $dbuser, $dbpass);
			mysql_select_db('simple_blog_db');
			$sql = "INSERT INTO comments".
				"(post_id,name,email,comment_content,comment_time)".
				"VALUES ('$Post_ID', '$Nama', '$Email', '$Komentar', NOW())";
			$retval = mysql_query( $sql, $conn );
			if(! $retval )
			{
				die('Could not enter data: ' . mysql_error());
			}
			echo "Komentar berhasil ditambahkan\n";
			mysql_close($conn);
		}
	?>
	
    <header class="art-header">
        <div class="art-header-inner" style="margin-top: 0px; opacity: 1;">
            <time class="art-time"><?php echo $Tanggal; ?></time>
            <h2 class="art-title"><?php echo $Judul; ?></h2>
            <p class="art-subtitle"></p>
        </div>
    </header>

    <div class="art-body">
        <div class="art-body-inner">
            <hr class="featured-article" />
            <p><?php echo $Konten; ?></p>

            <hr />
            
            <h2>Komentar</h2>
			
            <div id="contact-area">
                <form method="post" action=<?php $_PHP_SELF; ?>>
                    <label for="Nama">Nama:</label>
                    <input type="text" name="Nama" id="Nama">
        
                    <label for="Email">Email:</label>
                    <input type="text" name="Email" id="Email">
                    
                    <label for="Komentar">Komentar:</label><br>
                    <textarea name="Komentar" rows="20" cols="20" id="Komentar"></textarea>

                    <input type="submit" name="submit" value="Kirim" class="submit-button">
                </form>
            </div>

            <ul class="art-list-body">
			
				<li class="art-list-item">
                    <?php
					$dbhost = 'localhost';
					$dbuser = 'root';
					$dbpass = '';
					$conn = mysql_connect($dbhost, $dbuser, $dbpass);
					if(! $conn )
					{
						die('Could not connect: ' . mysql_error());
					}
					$sql = "SELECT * FROM comments WHERE post_id = $Post_ID";

					mysql_select_db('simple_blog_db');
					$retval = mysql_query( $sql, $conn );
					if(! $retval )
					{
						die('Could not get data: ' . mysql_error());
					}
					while($row = mysql_fetch_array($retval))
					{ 
						$Nama = $row['name'];
						$Email = $row['email'];
						$Komentar = $row['comment_content'];
						$Waktu_Komentar = $row['comment_time'];

					?>
					<div class="art-list-item-title-and-time">
                        <h2 class="art-list-title"><a href=<?php echo "post.php?Post_ID=$Post_ID"?>><?php echo $Nama;; ?></a></h2>
                        <div class="art-list-time"><?php echo $Waktu_Komentar; ?></div>
                    </div>
                    <p><?php echo $Komentar; ?></p>

					<?php
				} 
				mysql_close($conn);
				?>
                </li>

            </ul>
        </div>
    </div>

</article>

<footer class="footer">
    <div class="back-to-top"><a href="">Back to top</a></div>
    <!-- <div class="footer-nav"><p></p></div> -->
    <div class="psi">&Psi;</div>
    <aside class="offsite-links">
        Asisten IF3110 /
        <a class="rss-link" href="#rss">RSS</a> /
        <br>
        <a class="twitter-link" href="http://twitter.com/YoGiiSinaga">Yogi</a> /
        <a class="twitter-link" href="http://twitter.com/sonnylazuardi">Sonny</a> /
        <a class="twitter-link" href="http://twitter.com/fathanpranaya">Fathan</a> /
        <br>
        <a class="twitter-link" href="#">Renusa</a> /
        <a class="twitter-link" href="#">Kelvin</a> /
        <a class="twitter-link" href="#">Yanuar</a> /
        
    </aside>
</footer>

</div>

<script type="text/javascript" src="assets/js/fittext.js"></script>
<script type="text/javascript" src="assets/js/app.js"></script>
<script type="text/javascript" src="assets/js/respond.min.js"></script>
<script type="text/javascript">
  var ga_ua = '{{! TODO: ADD GOOGLE ANALYTICS UA HERE }}';

  (function(g,h,o,s,t,z){g.GoogleAnalyticsObject=s;g[s]||(g[s]=
      function(){(g[s].q=g[s].q||[]).push(arguments)});g[s].s=+new Date;
      t=h.createElement(o);z=h.getElementsByTagName(o)[0];
      t.src='//www.google-analytics.com/analytics.js';
      z.parentNode.insertBefore(t,z)}(window,document,'script','ga'));
      ga('create',ga_ua);ga('send','pageview');
</script>

</body>
</html>