<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdialogHelper
 *
 * @author Marcin
 */
class MDialogHelper
{
    static function error_dialog($message){
        $html = '';
        $html .= '<!-- messages error-->' . "\n";
        $html .= '<div class="modal fade" id="messageError" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">' . "\n";
        $html .= '	<div class="modal-dialog">' . "\n";
        $html .= '		<div class="modal-content">' . "\n";
        $html .= '			<div class="modal-header" style="background-color: #D9534F !important; color: white !important;">' . "\n";
        $html .= '				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>' . "\n";
        $html .= '				<h4 class="modal-title" id="myModalLabel">Warning</h4>' . "\n";
        $html .= '			</div>' . "\n";
        $html .= '			<div class="modal-body">' . "\n";
        $html .= '				'. $message . "\n";
        $html .= '			</div>' . "\n";
        $html .= '			<div class="modal-footer">' . "\n";
        $html .= '				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>' . "\n";
        $html .= '			</div>' . "\n";
        $html .= '		</div>' . "\n";
        $html .= '	</div>' . "\n";
        $html .= '</div>		' . "\n";
        $html .= '<!-- messages end -->' . "\n";
        $html .= '<script type="text/javascript">' . "\n";
        $html .= '$(window).on("load", function(){' . "\n";
        $html .= '$(\'#messageError\').modal(\'show\');' . "\n";
        $html .= '});' . "\n";
        $html .= '</script>' . "\n";
        return $html;
    }
}
