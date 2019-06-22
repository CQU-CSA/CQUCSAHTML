<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/iconfont.css" />
		<script type="text/javascript" src="js/vue.min.js"></script>
		<!--<link href="https://cdnjs.loli.net/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet">-->

	</head>

	<body>

		<div class="main">
			<div class="column">
				<div class="header">
					<h2>登录</h2>
				</div>
				<form class="form" id="login" action="login.php" method="post" @submit="checkForm">
					<div class="segment">
						<div class="field">
							<div class="input">
								<i class="icon iconfont right" v-bind:class="[iconStyleUser]"></i>
								<i class="icon iconfont icon-user"></i>
								<input v-bind:class="{ inputRed: isActiveUser }" name="user_id" placeholder="用户名" type="text" id="username" v-model="username" @blur="blur('user')">
							</div>
							<div class="mass" v-bind:class="{ show: isActiveUser }">
								请输入用户名！
							</div>
						</div>
						<div class="field">
							<div class="input">
								<i class="icon iconfont right" v-bind:class="[iconStylePass]"></i>
								<i class="icon iconfont icon-PC-passport"></i>
								<input v-bind:class="{ inputRed: isActivePass }" name="password" placeholder="密码" type="password" id="password" v-model="passwd" @blur="blur('pass')">
							</div>
							<div class="mass" v-bind:class="{ show: isActivePass }">
								请输入密码！
							</div>
						</div>
						<button name="submit" type="submit" class="submit">登录</button>
					</div>
				</form>
			</div>
		</div>
	</body>
	<script>
		new Vue({
			el: '#login',
			data: {
				fuser: false,
				fpasswd: false,
				isActiveUser: false,
				isActivePass: false,
				iconStyleUser: '',
				iconStylePass: '',
				username: '',
				passwd: ''
			},
			methods: {
				blur: function(str) {
					if(str == 'user') {
						if(this.username == '') {
							this.isActiveUser = true;
							this.iconStyleUser = 'icon-cuo red show';
						} else {
							this.isActiveUser = false;
							this.iconStyleUser = 'icon-duihao green show';
						}
					} else if(str == 'pass') {
						if(this.passwd == '') {
							this.isActivePass = true;
							this.iconStylePass = 'icon-cuo red show';
						} else {
							this.isActivePass = false;
							this.iconStylePass = 'icon-duihao green show';
						}
					}
				},
				checkForm: function(e) {
					if(this.username == '') {
						this.isActiveUser = true;
						this.iconStyleUser = 'icon-cuo red show';
						e.preventDefault();
					}
					if(this.passwd == '') {
						this.isActivePass = true;
						this.iconStylePass = 'icon-cuo red show';
						e.preventDefault();
					}
				}
			}
		});
	</script>

</html>
