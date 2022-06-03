/**
 * @package		plg_system_qlsmoothscroll
 * @copyright	Copyright (C) 2015 ql.de All rights reserved.
 * @author 		Mareike Riegel mareike.riegel@ql.de
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
jQuery(function($)
{
    $(document).ready(function ()
    {
        $('a.smoothscroll[href*=#]').click(function ()
        {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname)
            {
                var $target = $(this.hash);
                $target = $target.length && $target || $('[id=' + this.hash.slice(1) + ']');
                if ($target.length)
                {
                    var qlTargetOffset = $target.offset().top;
                    if (0 != qlSiteOffset)qlTargetOffset = qlTargetOffset - qlSiteOffset;
                    $('html,body').animate({scrollTop: qlTargetOffset}, 1000);
                    return false;
                }
            }
        });
    });
});