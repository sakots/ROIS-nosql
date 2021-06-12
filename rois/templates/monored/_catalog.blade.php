<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>{{$btitle}}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script>
			var css = GetCookie("CSS");
			if(css == ""){css = "mono_red.min.css";}
			document.write('<link rel="stylesheet" href="./templates/{{$themedir}}/css/' + css + '" type="text/css">');
			function SetCss(obj){
				var idx = obj.selectedIndex;
				file = obj.options[idx].value;
				SetCookie("CSS", file);
				window.location.reload();
			}
			function GetCookie(key){
				var tmp = document.cookie + ";";
				var tmp1 = tmp.indexOf(key, 0);
				if(tmp1 != -1){
					tmp = tmp.substring(tmp1, tmp.length);
					var start = tmp.indexOf("=", 0) + 1;
					var end = tmp.indexOf(";", start);
					return(unescape(tmp.substring(start,end)));
					}
				return("");
			}
			function SetCookie(key, val){
				document.cookie = key + "=" + escape(val) + ";max-age=31536000;";
			}
		</script>
		<noscript>
			<link rel="stylesheet" href="./templates/{{$themedir}}/css/mono_red.min.css" type="text/css">
		</noscript>
	</head>
	<body>
		<header id="header">
			<h1><a href="{{$self}}">{{$btitle}}</a></h1>
			<div>
				<a href="{{$home}}" target="_top">[ホーム]</a>
				<a href="{{$self}}?mode=admin_in">[管理モード]</a>
			</div>
			<hr>
			<div>
				<section>
					<p class="top menu">
						<a href="{{$home}}">[ホーム]</a>
						<a href="{{$self}}">[通常モード]</a>
						<a href="{{$self}}?mode=piccom">[投稿途中の絵]</a>
						<a href="#footer">[↓]</a>
					</p>
				</section>
				<section>
					<p class="sysmsg">{{$message}}</p>
				</section>
			</div>
			<hr>
			<div>
				<section class="epost">
					<form action="{{$self}}" method="post" enctype="multipart/form-data">
						<p>
							<label>幅：<input class="form" type="number" min="{{$pdefw}}" name="picw" value="{{$pdefw}}"></label>
							<label>高さ：<input class="form" type="number" min="{{$pdefh}}" name="pich" value="{{$pdefh}}"></label>
							<input type="hidden" name="mode" value="paint">
							<input class="button" type="submit" value="お絵かき">
							@if ($useanime == 1)
							<label><input type="checkbox" value="true" name="anime" title="動画記録" @if ($defanime == 1) checked @endif>アニメーション記録</label>
							@endif
							<label><input type="checkbox" value="true" name="useneo" title="NEOを使う" checked>NEOを使う</label>
						</p>
					</form>
					<ul>
						<li>iPadやスマートフォンでも描けるお絵かき掲示板です。</li>
						<li>お絵かきできるサイズは幅300～{{$pmaxw}}px、高さ300～{{$pmaxh}}pxです。</li>
						<li>NEOを使うのチェックを外すとしぃペインターが起動します。</li>
						{!!$addinfo!!}
					</ul>
                </section>
				<hr>
				@if ($catalogmode == 'catalog')
					<p>カタログモード</p>
				@endif
				@if ($catalogmode == 'search')
				<p>検索モード -「{{$author}}」の作品 - {{$s_result}}件</p>
				@endif
				@if ($catalogmode == 'hashsearch')
				<p>本文検索 -「{{$tag}}」- {{$s_result}}件</p>
				@endif
				@if ($catalogmode == 'catalog')
				<hr>
				<section class="paging">
					<p>
						@if ($back == 0)
							<span class="se">[START]</span>
						@else
							<span class="se">&lt;&lt;<a href="{{$self}}?page={{$back}}">[BACK]</a></span> 
						@endif
						@foreach ($paging as $pp)
							@if ($pp['p'] == $nowpage)
								<em class="thispage">[{{$pp['p']}}]</em>
							@else
								<a href="{{$self}}?page={{$pp['p']}}">[{{$pp['p']}}]</a>
							@endif
						@endforeach
						@if ($next == ($max_page + 1))
							<span class="se">[END]</span>
						@else
							<span class="se"><a href="{{$self}}?page={{$next}}">[NEXT]</a>&gt;&gt;</span> 
						@endif
					</p>
				</section>
				@endif
			</div>
		</header>
		<main>
			<div class="thread" id="catalog">
				@if (!empty($oya))
					@foreach ($oya as $bbsline)
					<div>
						<div>
							@if ($bbsline['picfile'] == true)
							<p>
								<a href="{{$self}}?mode=res&amp;res={{$bbsline['tid']}}" title="{{$bbsline['sub']}} (by {{$bbsline['name']}})"><img src="{{$path}}{{$bbsline['picfile']}}" alt="{{$bbsline['sub']}} (by {{$bbsline['name']}})"></a>
							</p>
							@else
							<p>
								<a href="{{$self}}?mode=res&amp;res={{$bbsline['tid']}}" title="{{$bbsline['sub']}} (by {{$bbsline['name']}})">{{$bbsline['sub']}} (by {{$bbsline['name']}})</a>
							</p>
							@endif
							<p>
								[{{$bbsline['tid']}}]
							</p>
						</div>
					</div>
					@endforeach
				@endif
				@if ($catalogmode == 'hashsearch')
					@if (!empty($ko))
						@foreach ($ko as $res)
							<div>
								<div>
									@if ($res['picfile'] == true)
										<p>
											<a href="{{$self}}?mode=res&amp;res={{$res['tid']}}" title="{{$res['sub']}} (by {{$res['name']}})"><img src="{{$path}}{{$res['picfile']}}" alt="{{$res['sub']}} (by {{$res['name']}})"></a>
										</p>
									@else
										<p>
											<a href="{{$self}}?mode=res&amp;res={{$res['tid']}}" title="{{$res['sub']}} (by {{$res['name']}})">{!! mb_substr($res['com'], 0, 30)!!}</a>
										</p>
									@endif
									<p>
										[{{$res['tid']}}]({[$res['iid']]})
									</p>
								</div>
							</div>
						@endforeach
					@endif
				@endif
			</div>
			<div>
				<section class="thread">
					@if ($catalogmode == 'catalog')
					<section class="paging">
						<p>
							@if ($back == 0)
								<span class="se">[START]</span>
							@else
								<span class="se">&lt;&lt;<a href="{{$self}}?page={{$back}}">[BACK]</a></span> 
							@endif
							@foreach ($paging as $pp)
								@if ($pp['p'] == $nowpage)
									<em class="thispage">[{{$pp['p']}}]</em>
								@else
									<a href="{{$self}}?page={{$pp['p']}}">[{{$pp['p']}}]</a>
								@endif
							@endforeach
							@if ($next == ($max_page + 1))
								<span class="se">[END]</span>
							@else
								<span class="se"><a href="{{$self}}?page={{$next}}">[NEXT]</a>&gt;&gt;</span> 
							@endif
						</p>
					</section>
					<hr>
					@endif
					<p>作者名/本文(ハッシュタグ)検索</p>
					<form class="search" method="GET" action="{{$self}}">
						<input type="hidden" name="mode" value="search">
						<label><input type="radio" name="bubun" value="bubun">部分一致</label>
						<label><input type="radio" name="bubun" value="kanzen">完全一致</label>
						<label><input type="radio" name="tag" value="tag">本文(ハッシュタグ)</label>
						<br>
						<input type="text" name="search" placeholder="検索" size="20">
						<input type="submit" value=" 検索 ">
					</form>
					<form class="delf" action="{{$self}}" method="post">
						<p>
							<select name="delt">
								<option value="0">親</option>
								@if ($catalogmode == 'hashsearch')
									<option value="1">レス</option>
								@endif
							</select>
							No <input class="form" type="number" min="1" name="delno" value="" autocomplete="off">
							Pass <input class="form" type="password" name="pwd" value="" autocomplete="current-password">
							<select class="form" name="mode">
								<option value="edit">編集</option>
								<option value="del">削除</option>
							</select>
							<input class="button" type="submit" value=" OK ">
							<input class="button" type="submit" value=" OK ">
							<span class="stylechanger">
								<select class="form" name="select" id="mystyle" onchange="SetCss(this);">
									<option value="mono_red.min.css">Color</option>
									<option value="mono_red.min.css"> RED</option>
									<option value="mono_dev.min.css"> DEV</option>
									<option value="mono_main.min.css"> MONO</option>
									<option value="mono_dark.min.css"> dark</option>
									<option value="mono_deep.min.css"> deep</option>
									<option value="mono_mayo.min.css"> MAYO</option>
								</select>
							</span>
						</p>
					</form>
				</section>
			</div>
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
		<script src="./templates/{{$themedir}}/jquery-3.5.1.min.js"></script>
		<script>
			$(function(){//2度押し対策
				$('[type="submit"]').click(function(){
					$(this).prop('disabled',true);
					$(this).closest('form').submit();
				});
			});
		</script>
	</body>
</html>