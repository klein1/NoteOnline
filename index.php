<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>便利贴</title>
		<style>
			* {
				margin: 0px;
				padding: 0px;
			}
			
			body {
				/*background: -webkit-linear-gradient(top, rgb(203, 235, 219) 0%, rgb(55, 148, 192) 120%);
		background: -moz-linear-gradient(top, rgb(203, 235, 219) 0%, rgb(55, 148, 192) 120%);*/
				background-color: lightblue;
				font-family: '微软雅黑', sans-serif;
				font-size: 16px;
				position: fixed;
				height: 100%;
				width: 100%;
				top: 0px;
				left: 0px;
				bottom: 0px;
				right: 0px;
			}
			
			.item {
				position: relative;
				width: 150px;
				height: 150px;
				line-height: 30px;
				-webkit-border-bottom-left-radius: 20px 500px;
				-webkit-border-bottom-right-radius: 500px 30px;
				-webkit-border-top-right-radius: 5px 100px;
				-moz-border-bottom-left-radius: 20px 500px;
				-moz-border-bottom-right-radius: 500px 30px;
				-moz-border-top-right-radius: 5px 100px;
				box-shadow: 0 2px 10px 1px rgba(0, 0, 0, 0.2);
				-webkit-box-shadow: 0 2px 10px 1px rgba(0, 0, 0, 0.2);
				-moz-box-shadow: 0 2px 10px 1px rgba(0, 0, 0, 0.2);
			}
			
			#container {
				position: absolute;
				top: 20%;
				bottom: 10% left:0;
				width: 100%;
				height: 70%;
			}
			
			#container p {
				height: 110px;
				margin: 10px;
				overflow: hidden;
				word-wrap: break-word;
				line-height: 1.5;
				font-size: 12px;
			}
			
			#container a {
				text-decoration: none;
				color: white;
				position: absolute;
				bottom: 5px;
				right: 5px;
				coler: red;
				font-size: 13px;
			}
			
			#input {
				border: 0;
				border-radius: 5px;
				position: fixed;
				height: 30px;
				padding: 0 10px;
				line-height: 30px;
				width: 300px;
				margin: 30px calc((100% - 320px)/2);
				font-size: 18px;
				z-index: 1000;
			}
		</style>
	</head>

	<body>
		<input id="input" name="input" type="text" maxlength="50" placeholder="随便说说吧...按回车留言" />
		<div id="container" style="">
		</div>
		<script src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery.easyui.min.js"></script>

		<script>
			(function($) {

				var container;

				//随机颜色，十六进制方法；
				function getRandomColor() {
					var rand = Math.floor(Math.random() * 0xFFFFFF).toString(16);
					if(rand.length == 6) {
						return rand;
					} else {
						return getRandomColor();
					}
				}

				//	var colors = ['#96C2F1', '#BBE1F1', '#E3E197', '#F8B3D0', '#FFCC00'];

				var createItem = function(text) {
					//		var color = colors[parseInt(Math.random() * 5, 10)]
					var color = "#" + getRandomColor();
					$('<div class="item"><p>' + $('<div>').text(text).html() + '</p><a href="#">隐藏</a></div>').css({
						'background': color
					}).appendTo(container).drag();
				};

				$.fn.drag = function() {

					var $this = $(this);
					var parent = $this.parent();

					var pw = parent.width();
					var ph = parent.height();
					var thisWidth = $this.width() + parseInt($this.css('padding-left'), 10) + parseInt($this.css('padding-right'), 10);
					var thisHeight = $this.height() + parseInt($this.css('padding-top'), 10) + parseInt($this.css('padding-bottom'), 10);

					var randY = parseInt(Math.random() * (ph - thisHeight), 10);
					var randX = parseInt(Math.random() * (pw - thisWidth), 10);

					$this.css({
						"cursor": "move",
						"position": "absolute"
					}).css({
						top: randY,
						left: randX
					}).draggable();

				};

				var init = function() {

					container = $('#container');

					container.on('click', 'a', function() {
						$(this).parent().remove();
					});

					var tests = [];
<?php
$servername = "115.159.181.16";
$username = "root";
$password = "udcong";
$dbname = "udcong";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 
 
$sql = "select content from db_note";
$result = mysqli_query($conn, $sql);
 
if (mysqli_num_rows($result) > 0) {
    // 输出数据
    while($row = mysqli_fetch_assoc($result)) {
        echo "tests.push('".$row["content"]."');";
    }
} else {
    echo "";
}

$conn->close();
?>
					$.each(tests, function(i, v) {
						createItem(v);
					});

					$('#input').keydown(function(e) {
						var $this = $(this);
						if(e.keyCode == '13') {
							var value = $this.val();
							if(value) {
								$.ajax({
									type: "post",
									url: "upload.php",
									data: {
										input: value
									},
									success: function() {
										createItem(value);
										$this.val('');
										$this.blur();
									},
									error: function() {

									}
								});
							}
						}
					});

				};

				$(function() {
					init();
				});

			})(jQuery);
		</script>
	</body>

</html>