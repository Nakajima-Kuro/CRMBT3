<div class="brand clearfix">
<h4 class="pull-left text-white" style="margin:20px 0px 0px 20px; font-size: 20px;"><i class="fa fa-rocket"></i>&nbsp; Quản lý nhân viên</h4>
		<span class="menu-btn"><i class="fa fa-bars"></i></span>
		<ul class="ts-profile-nav">
			
			<li class="ts-account">
				<a href="#"><img src="../images/<?php if($result->image) { echo htmlentities($result->image); } else { echo "user.jpg"; };?>" 
						class="ts-avatar hidden-side" alt="../images/user.jpg"> Admin <i class="fa fa-angle-down hidden-side"></i></a>
				<ul>
					<li><a href="change-password.php">Đổi mật khẩu</a></li>
					<li><a href="logout.php">Đăng xuất</a></li>
				</ul>
			</li>
		</ul>
	</div>
