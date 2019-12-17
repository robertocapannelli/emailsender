<?php

namespace App\Controller;

use App\Helper;

class HandleTrafficTracking {

    /**
	 * Add google analytics tracking code
	 */
	public function googleAnalitycs() {

		$helper = Helper::getInstance();
		$helper->setDotenv();

		$helper->getDotenv()->load();

		if ( isset( $_ENV['GA_ID'] ) and ! empty( $_ENV['GA_ID'] ) ) {
			?>
            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=<?= $_ENV['GA_ID']; ?>"></script>
            <script>
                window.dataLayer = window.dataLayer || [];

                function gtag() {
                    dataLayer.push(arguments);
                }

                gtag('js', new Date());

                gtag('config', '<?= $_ENV["GA_ID"]; ?>');
            </script>
		<?php }
	}

	public function facebookPixel() {
		$helper = Helper::getInstance();
		$helper->setDotenv();

		$helper->getDotenv()->load();

		if ( isset( $_ENV['FB_PIXEL_ID'] ) && ! empty( $_ENV['FB_PIXEL_ID'] ) ) {
			?>
            <!-- Facebook Pixel Code -->
            <script>
                !function (f, b, e, v, n, t, s) {
                    if (f.fbq) return;
                    n = f.fbq = function () {
                        n.callMethod ?
                            n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                    };
                    if (!f._fbq) f._fbq = n;
                    n.push = n;
                    n.loaded = !0;
                    n.version = '2.0';
                    n.queue = [];
                    t = b.createElement(e);
                    t.async = !0;
                    t.src = v;
                    s = b.getElementsByTagName(e)[0];
                    s.parentNode.insertBefore(t, s)
                }(window, document, 'script',
                    'https://connect.facebook.net/en_US/fbevents.js');
                fbq('init', '<?= $_ENV['FB_PIXEL_ID']; ?>>');
                fbq('track', 'PageView');

            </script>
            <noscript>
                <img height="1" width="1" style="display:none"
                     src="https://www.facebook.com/tr?id=<?= $_ENV['FB_PIXEL_ID']; ?>&ev=PageView&noscript=1"/>
            </noscript>
            <!-- End Facebook Pixel Code -->
		<?php }
	}
}