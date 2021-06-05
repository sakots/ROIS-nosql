<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="./templates/{{$themedir}}/css/mono_main.css" type="text/css">
		<title>{{$btitle}}</title>
	</head>
	<body>
		<header>
			<h1><a href="{{$self}}">{{$btitle}}</a></h1>
			<div>
				<a href="{{$home}}" target="_top">[ホーム]</a>
				<a href="{{$self}}?mode=admin_in">[管理モード]</a>
			</div>
			<hr>
			<section>
				<p class="menu">
					<a href="{{$self}}">[トップ]</a>
				</p>
			</section>
			<section>
				<p class="sysmsg">{{$message}}</p>
			</section>
			<hr>
		</header>
		<main>
			<section>
				<div class="thread">
					<h1 class="oekaki">投稿フォーム</h1>
					<div class="tmpimg">
						@if (isset($temp))
						<div>
							@foreach ($temp as $tmp)
								@if (isset($tmp['src']))
									@if (isset($tmp['srcname']))
									<figure>
										<img src="{{$tmp['src']}}">
										<figcaption>{{$tmp['srcname']}}[{{$tmp['date']}}]</figcaption>
									</figure>
									@endif
								@endif
							@endforeach
						</div>
						@else
						<p>Not OEKAKI image</p>
						@endif
					</div>
					@if (isset($temp))
					<form class="ppost postform" action="{{$self}}?mode=regist" method="post">
						@if (isset($ptime))
						<p>
							描画時間：{{$ptime}}
							@if ($sptime == 1) <label><input type="checkbox" name="secptime" value="true">描画時間を隠す</label> @endif
						</p>
						@endif
						<table>
							<tr>
								<td>name
									@if ($use_name == 1)
									*
									@endif
								</td>
								<td><input type="text" name="name" size="28" autocomplete="username"></td>
							</tr>
							<tr>
								<td>mail</td>
								<td><input type="text" name="mail" size="28" value="" autocomplete="email"></td>
							</tr>
							<tr>
								<td>URL</td>
								<td><input type="text" name="url" size="28" value="" autocomplete="url"></td>
							</tr>
							<tr>
								<td>subject
									@if ($use_sub == 1)
									*
									@endif
								</td>
								<td>
									<input type="text" name="sub" size="35" autocomplete="section-sub">
									<input type="submit" name="send" value="書き込む">
									<input type="hidden" name="parent" value="{{$parent}}">
									<input type="hidden" name="invz" value="0">
									<input type="hidden" name="img_w" value="0">
									<input type="hidden" name="img_h" value="0">
									@if (isset($ptime))<input type="hidden" name="ptime" value="{{$ptime}}">@endif
									<input type="hidden" name="exid" value="0">
								</td>
							</tr>
							<tr>
								<td>
									comment
									@if ($use_com == 1)
									*
									@endif
								</td>
								<td><textarea name="com" cols="48" rows="4" wrap="soft"></textarea></td>
							</tr>
							@if (isset($temp))
							<tr>
								<td>imgs</td>
								<td>
									<select name="picfile">
									@foreach ($temp as $tmp)
										@if (isset($tmp['srcname']))}<option value="{{$tmp['srcname']}}">{{$tmp['srcname']}}</option>
										@endif
									@endforeach
								</select>
								</td>
							</tr>
							@endif
							<tr>
								<td>pass</td>
								<td>
									<input type="password" name="pwd" size="8" value="" autocomplete="current-password">
									(記事の編集削除用。英数字で)
								</td>
							</tr>
						</table>
					</form>
					@endif
				</div>
			</section>
			<script src="loadcookie.js"></script>
			<script>
				l(); //LoadCookie
			</script>
		</main>
		<footer id="footer">
			<div class="copy">
				<!-- 著作権表示 -->
				<p>
					<a href="https://dev.oekakibbs.net/" target="_top">ROIS {{$ver}}</a>
					Web Style by <a href="https://dev.oekakibbs.net/" target="_top" title="{{$tname}} {{$tver}} (by お絵かきBBSラボ)">{{$tname}}</a>
				</p>
				<p>
					OekakiApplet - 
					<a href="https://github.com/funige/neo/" target="_top" rel="noopener noreferrer" title="by funige">PaintBBS NEO</a>,
					<a href="http://hp.vector.co.jp/authors/VA016309/" target="_top" rel="noopener noreferrer" title="by しぃちゃん">Shi-Painter</a>
				</p>
				<p>
					UseFunction -
					<!-- http://wondercatstudio.com/ -->DynamicPalette,
					<a href="https://github.com/EFTEC/BladeOne" target="_top" rel="noopener noreferrer" title="by EFTEC">BladeOne</a>
				</p>
			</div>
		</footer>
	</body>
</html>
