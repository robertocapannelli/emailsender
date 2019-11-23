<?php

namespace Controller;

use Dotenv;

class HandleTrafficTracking {

	private $dotenv;

	/**
	 * @return mixed
	 */
	public function getDotenv() {
		return $this->dotenv;
	}

	/**
	 * @param mixed $dotnev
	 */
	public function setDotenv(): void {
		$this->dotenv = Dotenv\Dotenv::create( __DIR__ . "/../" );
	}

	/**
	 * Add google analytics tracking code
	 */
	public function googleAnalitycs() {
		$this->setDotenv();
		$this->getDotenv()->load();
		?>

        <!--TODO check if env vars are set-->
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

		<?php
	}

	public function facebookPixel() {
		$this->setDotenv();
		$this->getDotenv()->load();
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

		<?php
	}
}