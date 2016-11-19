<?php
/**
 * @author 	Tom Konopelski - www.konopelski.info
 * @copyright  	Copyright (C) 2014 goldpicasagallery.konopelski.info. All rights reserved.
 * @license    	GNU General Public License version 2 or later; see LICENSE
 */
defined('_JEXEC') or die('Restricted access');
?>

<?php

$defFontsize='11px';
if ($params->get('fontsize', '')) {
    $defFontsize=$params->get('fontsize', $defFontsize);
}
$defLineHeight='1.1em';
if ($params->get('lineheight', '')) {
    $defLineHeight=$params->get('lineheight', $defLineHeight);
}

$defFontColor='#FFFFFF';
if ($params->get('fontcolor', '')) {
    $defFontColor=$params->get('fontcolor', $defFontColor);
}

$defOverlayColor='#000';
if ($params->get('overlaycolor', '')) {
    $defOverlayColor=$params->get('overlaycolor', $defOverlayColor);
}

$defOverlayLevel='0.7';
if ($params->get('overlaylevel', '')) {
    $defOverlayLevel=$params->get('overlaylevel', $defOverlayLevel);
}
$defMootoolscore='';
if ($params->get('mootoolscore', '')) {
    $defMootoolscore=$params->get('mootoolscore', '');
}

?>

<h1>
    <?php
    echo JText::_('JACTION_COMPONENT_SETTINGS');
    ?>

</h1>

<form method="post">
    <fieldset class="adminform long">
        <legend>Theme</legend>

        <table>
            <tr>
                <td>
                    <input type="radio" name="gpgsettings[theme]" value="clasic"  <?php if ($params->get('theme', '')==='clasic') echo ' checked="checked" '; ?>>
                </td>
                <td>
                    Clasic
                </td>
                <td>
                    &nbsp;
                    &nbsp;
                </td>
                <td>
                    <input type="radio" name="gpgsettings[theme]" value="box" <?php if ($params->get('theme', '')==='box') echo ' checked="checked" '; ?>>
                </td>
                <td>
                Box
                </td>
            </tr>

        </table>

    </fieldset>
    <br />
    <br />

    <fieldset class="adminform long">
        <legend>Box theme settings</legend>

        <table>
            <tr>
                <td>
                    Font size:
                </td>
                <td>
                    <input type="text" name="gpgsettings[fontsize]" size="6" placeholder="11px" value="<?php echo $defFontsize; ?>" />
                </td>
                <td>
                    The font-size property sets the size of a font. Examples: 12px, 1.2em, 0.8em
                </td>
            </tr>

            <tr>
                <td>
                    Font line-height:
                </td>
                <td>
                    <input type="text" name="gpgsettings[lineheight]" size="6" placeholder="1.1em" value="<?php echo $defLineHeight; ?>" />
                </td>
                <td>
                    The line-height property specifies the line height.
                </td>
            </tr>

            <tr>
                <td>
                    Font color:
                </td>
                <td>
                    <input type="text" name="gpgsettings[fontcolor]" id="examplecolor"
                           class="input-colorpicker" value="<?php echo $defFontColor; ?>" size="10" />
                </td>
                <td>
                    <?php echo $defFontColor; ?>
                </td>
            </tr>

            <tr>
                <td>
                    Overlay color:
                </td>
                <td>
                    <input type="text" name="gpgsettings[overlaycolor]" id="examplecolor"
                           class="input-colorpicker" value="<?php echo $defOverlayColor; ?>" size="10" />
                </td>
                <td>
                    Sets the background color of a overlay.
                </td>
            </tr>

            <tr>
                <td>
                    Overlay opacity-level:
                </td>
                <td>

                    <select name="gpgsettings[overlaylevel]">
                    <?php
                    $overlayList=array(1, 0.9 , 0.8, 0.7, 0.6, 0.5, 0.4, 0.3, 0.2, 0.1);
                    foreach ($overlayList as $ol) {
                        $selOv='';
                        if ($defOverlayLevel == $ol) {
                            $selOv = ' selected="selected" ';
                        }

                        echo '<option value="'.$ol.'" '.$selOv.'>'.$ol.'</option>';
                    }
                    ?>
                    </select>

                </td>
                <td>
                    The opacity-level describes the transparency-level, where 1 is not transperant at all, 0.5 is 50% see-through, and 0 is completely transparent.
                </td>
            </tr>



        </table>





    </fieldset>


    <fieldset class="adminform long">
        <legend>Other</legend>

        <table>
            <tr>
                <td>
                    Force to load mootools-core.js
                </td>
                <td>
                    <?php
                        echo settingsViewYesNo('mootoolscore', $defMootoolscore);
                    ?>
                </td>

            </tr>

        </table>

    </fieldset>
    <br />


    &nbsp;
    &nbsp;
    <input type="submit" value="Save">
    <br />
    <br />

</form>
<?php
//var_dump($params->toArray());



function settingsViewYesNo($name, $default=false, $showDefault=true) {
    $html='';
    $html.='<select name="gpgsettings['.$name.']">';
    if ($showDefault) {
        $html.='<option value="" >- default -</option>';
    }
    $sel = ($default==='yes') ? ' selected="selected" ' : '';
    $html.='<option value="yes" '.$sel.'>YES</option>';
    $sel = ($default==='no') ? ' selected="selected" ' : '';
    $html.='<option value="no" '.$sel.'>NO</option>';
    $html.='</select>';
    return $html;

}



?>