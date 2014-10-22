@section('title', trans('user.profile')) 
@section('styles')
<link rel="stylesheet"
	href="{{ URL::asset('css/user.css') }}">

@stop 

@section('scripts')
<script type="text/javascript">
function getMyPorfile() {
	$.ajax({ 
        url: "{{URL::route('portfolio.profile_showmy')}}",
        dataType: 'json', 
        type: "GET", 
        success: function(output){ 
            alert(output);     
            $('#user-info').css('display','none');;
        } 
    }); 
}

jQuery(function ($){
	$('#myinvest').click(function(){
		getMyPorfile() ;
		});
	
});

</script>
@stop


@section('content')
<div class="container">
	<div class="uc-full-box">
	
			<div class="span4 col-md-3">
				<div class="uc-nav-box">
					<div class="box-hd">
						<h3 class="title">{{trans('user.center')}}</h3>
					</div>
					<div class="box-bd">
						<ul class="uc-nav-list">
							<li class="current"><a
								href="{{ url('user/profile')}}">{{trans('user.info')}}</a>
								
							</li>
							<li><a
								href="#">我的订单</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="uc-nav-box">
					<div class="box-hd">
						<h3 class="title">{{trans('portfolio.portfolio')}}</h3>
					</div>
					<div class="box-bd">
						<ul class="uc-nav-list">
							<li id="myinvest" ><a href="{{ route('portfolio.profile_showmy')}}" }}">{{trans('portfolio.myportfolio')}}</a></li>
							<li><a href="{{url('user/profile')}}">{{trans('portfolio.buy_portfolio')}}</a></li>
							<li><a href="#">{{trans('portfolio.follow_portfolio')}}</a></li>
						</ul>
					</div>
				</div>
				<div class="uc-nav-box">
					<div class="box-hd">
						<h3 class="title">{{trans('user.account_manage')}}</h3>
					</div>
					<div class="box-bd">
						<ul class="uc-nav-list">
							<li><a
								href="#"
								target="_blank">{{trans('usr.modify_password') }}</a></li>
							<li><a href="#" target="_blank">VIP认证</a></li>
						</ul>
					</div>
				</div>
			</div>
			<!-- .span4 END -->

			<div class="span16 col-md-9">
				<div class="xm-box uc-box">
					<div class="xm-line-box uc-info-box">
						<div class="box-bd" id="user-info">
							<img class="uc-avatar"
								src=""
								alt="">
							<div class="uc-info">
								<h3 class="uc-welcome">
									<span class="user-name"></span>早上好～
								</h3>
								<div class="uc-info-detail">
									<div class="info-notice">
										账户安全级别： <span
											class="icon-common icon-safe-level icon-safe-level-2"></span>
										普通 <span class="sep">|</span> <span
											class="icon-common icon-safe-open"></span> 绑定手机 <span
											class="sep">|</span> <span
											class="icon-common icon-safe-closed"></span> <a
											href="#"
											target="_blank">绑定邮箱</a> <span class="sep">|</span>
										<div class="notice-safe-tip uc-tooltip">
											如何提高安全级别？
											<div class="uc-tooltip-popup hide">
												<ol>
													<li><a href="#"
														target="_blank">绑定手机</a>，确保您本人登陆</li>
													<li><a href="#"
														target="_blank">绑定邮箱</a>，密码、账户找回必备</li>
												</ol>
												<span class="arrow"></span>
											</div>
										</div>
									</div>
									<div class="info-goods">
										
									</div>
								</div>
							</div>
						</div>

					</div>
					<!-- .uc-info-box END -->

					<div class="xm-line-box uc-home-box">
						<div class="box-hd">
							<h3 class="title">未支付订单</h3>
						</div>
						<div class="box-bd">
							<div class="uc-tip-section">
								<p class="empty">
									您暂时没有未付款订单。<a href="#">挑挑喜欢的商品去»</a>
								</p>
							</div>
						</div>
					</div>
					<!-- .uc-home-box END -->


					<div class="row">

					</div>

				</div>
			</div>


		</div>

	</div>
</div>

@stop



