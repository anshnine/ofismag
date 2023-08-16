<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>
<? if (count($arResult) > 0) { ?>
    <a href="/catalog/compare/"><span class="fa">&#xf006;</span> В сравнении <i><?= (count($arResult)) ?></i></a>
<? }else{?>
    <a href="/catalog/compare/"><span class="fa">&#xf006;</span> В сравнении <i>0</i></a>
<?}?>
