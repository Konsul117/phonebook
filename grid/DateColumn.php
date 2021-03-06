<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\grid;

use Yii;
use yii\grid\Column;

class DateColumn extends Column {
	
	public $attribute;
	
	public $label;
    /**
     * @var boolean whether the header label should be HTML-encoded.
     * @see label
     * @since 2.0.1
     */
    public $encodeLabel = true;
    /**
     * @var string|\Closure an anonymous function that returns the value to be displayed for every data model.
     * The signature of this function is `function ($model, $key, $index, $column)`.
     * If this is not set, `$model[$attribute]` will be used to obtain the value.
     *
     * You may also set this property to a string representing the attribute name to be displayed in this column.
     * This can be used when the attribute to be displayed is different from the [[attribute]] that is used for
     * sorting and filtering.
     */
    public $value;
    /**
     * @var string|array in which format should the value of each data model be displayed as (e.g. `"raw"`, `"text"`, `"html"`,
     * `['date', 'php:Y-m-d']`). Supported formats are determined by the [[GridView::formatter|formatter]] used by
     * the [[GridView]]. Default format is "text" which will format the value as an HTML-encoded plain text when
     * [[\yii\i18n\Formatter]] is used as the [[GridView::$formatter|formatter]] of the GridView.
     */
    public $format = 'text';
    /**
     * @var boolean whether to allow sorting by this column. If true and [[attribute]] is found in
     * the sort definition of [[GridView::dataProvider]], then the header cell of this column
     * will contain a link that may trigger the sorting when being clicked.
     */
    public $enableSorting = true;
    /**
     * @var array the HTML attributes for the link tag in the header cell
     * generated by [[\yii\data\Sort::link]] when sorting is enabled for this column.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $sortLinkOptions = [];
    /**
     * @var string|array|boolean the HTML code representing a filter input (e.g. a text field, a dropdown list)
     * that is used for this data column. This property is effective only when [[GridView::filterModel]] is set.
     *
     * - If this property is not set, a text field will be generated as the filter input;
     * - If this property is an array, a dropdown list will be generated that uses this property value as
     *   the list options.
     * - If you don't want a filter for this data column, set this value to be false.
     */
    public $filter;
    /**
     * @var array the HTML attributes for the filter input fields. This property is used in combination with
     * the [[filter]] property. When [[filter]] is not set or is an array, this property will be used to
     * render the HTML attributes for the generated filter input fields.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $filterInputOptions = ['class' => 'form-control', 'id' => null];
	
	protected function renderDataCellContent($model, $key, $index)
    {
        return 'asd';
    }
	
}
