<?php

namespace Motivo\EditorJsDataConverter\Traits;

use Illuminate\Http\Request;
use Spatie\Html\Html;

trait WithHtml
{
    /** @var \Spatie\Html\Html */
    private $html;

    public function __construct()
    {
        $this->html = (new Html(new Request()));
    }
}
