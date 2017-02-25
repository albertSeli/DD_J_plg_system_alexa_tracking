<?php
/**
 * @version    1-2-0-1 // Y-m-d 2016-05-22
 * @author     HR IT-Solutions Florian Häusler https://www.hr-it-solutions.com
 * @copyright  Copyright (C) 2011 - 2016 Didldu e.K. | HR IT-Solutions
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 **/

defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');
jimport('joomla.access.access');

/**
 * Joomla! system plugin to add the Alexa - Analytics Tracking Code to your website.
 */
class plgSystemDD_Alexa_Tracking extends JPlugin
{
	protected $app;

	public function onBeforeCompileHead()
	{
		// Front end
		if ($this->app->isSite())
		{
			$doc = JFactory::getDocument();

			// Setup Alexa meta tag
			$doc->setMetaData("alexaVerifyID", $this->params->get('alexaverifyid'));
		}
	}

	public function onAfterRender()
	{
		// Front end
		if ($this->app->isSite())
		{
			// Plugin parameter
			$certifycode = $this->params->get('certifycode');
			$trackingurl = $this->params->get('trackingurl');

			// Alexa Tracking snipped
			$alexascript = '<!-- Alexa Script -->
<script type="text/javascript">
	_atrk_opts = { atrk_acct:"' . htmlentities($certifycode, ENT_QUOTES, 'UTF-8') . '", domain:"' . htmlentities($trackingurl, ENT_QUOTES, 'UTF-8') . '",dynamic: true};
	(function() { var as = document.createElement("script"); as.type = "text/javascript"; as.async = true; as.src = "https://d31qbv1cthcecs.cloudfront.net/atrk.js"; var s = document.getElementsByTagName("script")[0];s.parentNode.insertBefore(as, s); })();
</script>
<noscript><img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=' . htmlentities($certifycode, ENT_QUOTES, 'UTF-8') . '" style="display:none" height="1" width="1" alt="" /></noscript>
<!-- END Alexa Script -->';

			// Add Alexa Tracking snipped just bevore closing body tag;
			$html = str_replace('</body>', $alexascript . PHP_EOL . '</body>', $this->app->getBody());

			$this->app->setBody($html);
		}
	}
}