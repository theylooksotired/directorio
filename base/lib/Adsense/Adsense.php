<?php
class Adsense {

	static public function responsive() {
		if (DEBUG) return '<div class="adsense adsenseTest">Publicidad</div>';
		return '<div class="adsense">
					<!-- Responsive -->
					<ins class="adsbygoogle"
					     style="display:block"
					     data-ad-client="ca-pub-7429223453905389"
					     data-ad-slot="2090660201"
					     data-ad-format="auto"></ins>
					<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
				</div>';
	}

	static public function top() {
		if (DEBUG) return '<div class="adsense adsenseTest">Publicidad</div>';
		return '<div class="adsense">
					<!-- Directorio - Top -->
					<ins class="adsbygoogle"
					     style="display:block"
					     data-ad-client="ca-pub-7429223453905389"
					     data-ad-slot="8819153807"
					     data-ad-format="auto"></ins>
					<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
				</div>';
	}

	static public function side() {
		if (DEBUG) return '<div class="adsense adsenseTest">Publicidad</div>';
		return '<div class="adsense">
					<!-- Directorio - Side -->
					<ins class="adsbygoogle"
					     style="display:block"
					     data-ad-client="ca-pub-7429223453905389"
					     data-ad-slot="2772620209"
					     data-ad-format="auto"></ins>
					<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
				</div>';
	}

	static public function inline() {
		if (DEBUG) return '<div class="adsense adsenseTest">Publicidad</div>';
		return '<div class="adsense">
					<!-- Directorio - Inline -->
					<ins class="adsbygoogle"
					     style="display:block"
					     data-ad-client="ca-pub-7429223453905389"
					     data-ad-slot="4249353406"
					     data-ad-format="auto"></ins>
					<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
				</div>';
	}

	static public function links() {
		if (DEBUG) return '<div class="adsenselinks adsenseTest">Publicidad</div>';
		return '<div class="adsenselinks">
					<!-- Links unit -->
					<ins class="adsbygoogle"
					     style="display:inline-block;width:120px;height:90px"
					     data-ad-client="ca-pub-7429223453905389"
					     data-ad-slot="3140087801"></ins>
					<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
				</div>';
	}

	static public function linksall() {
		return '<div class="adsenselinksWrapper">
					'.Adsense::links().'
					'.Adsense::links().'
					'.Adsense::links().'
				</div>';
	}
	
}
?>