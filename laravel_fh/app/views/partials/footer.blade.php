
<script
	type="text/javascript"
	src="{{url('js/vendor/jquery-ui-1.10.3.custom.min.js')}}"></script>
<script>
function clickWechat() {
	$('#J_modalWeixin').modal('show');
}

</script>

<div class="site-footer">
	<div class="container">
		<div class="footer-service">
			<ul class="list-service clearfix">
			</ul>
		</div>
		<div class="footer-links clearfix">
			<dl class="col-links ">
				<dt>{{ trans('partials.footer_links')}}</dt>
				<dd>
					<a rel="nofollow" href="#" target="_blank">{{
						trans('partials.footer_links')}}</a>
			
			</dl>

			<dl class="col-links ">
				<dt>{{trans('partials.about_us')}}</dt>
				<dd>
					<a rel="nofollow" href="#" target="_blank" onclick=""
						data-stat-id="0011014">了解我们</a>
				</dd>

				<dd>
					<a rel="nofollow" href="#" target="_blank" data-stat-id="0011015">加入我们</a>
				</dd>

				<dd>
					<a rel="nofollow" href="#" target="_blank">联系我们</a>
				</dd>
			</dl>

			<dl class="col-links2 ">
				<dt>关注我们</dt>
				<dd>
					<a rel="nofollow" href="#" target="_blank">新浪微博</a>
				</dd>
				<dd>
					<a rel="nofollow" href="#" target="_blank">YY频道</a>
				</dd>
				<dd>
					<a rel="nofollow" class="J_modalWeixin" href="javascript: void(0);"
						onclick="clickWechat()" data-stat-id="0011019">官方微信</a>
				</dd>
			</dl>
		</div>

		<div class="footer-info clearfix">
			<div class="info-text ">

		  <p>	提示：陆家最金融之家里任何用户或者嘉宾的发言，都有其特定立场，投资决策需要建立在独立思考之上。 </p>
				<p>
					©<a href="http://www.financehouse.com.cn/" target="_blank" title="financehouse"
						
						data-stat-id="79fe2eae924d2a2e-d7577c2c6d9aff60">2014 financehouse </a>
					沪ICP备14039091号 	</p>
				<div class="info-links">
					<a
						href="#"><img
						src="img/cnnicVerifyseal.png" alt="可信网站">
					</a> <a
						href="#"><img
						src="img/szfwVerifyseal.gif" alt="诚信网站">
					</a> 

				</div>
			</div>

		</div>
	</div>




	<!-- Modal -->
	<div class="modal fade" id="J_modalWeixin" tabindex="-1"
		data-width="480" data-height="520" role="dialog"
		aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">

					<h3>陆家最金融之家官方微信二维码</h3>
				</div>
				<div class="modal-body" style="padding-top: 10px;">
					<p style="margin: 0 0 10px;">
						打开微信，点击右上角的“魔法棒”，选择“扫一扫”功能，<br>对准下方二维码即可。
					</p>
					<img alt="" src="{{ URL::asset('img/wechat_code.jpg') }}">
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->