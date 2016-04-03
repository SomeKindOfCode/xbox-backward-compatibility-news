{extends file="./elements/layout.tpl"}

{block name=body}

<div class="page-header">
<h1>
    Xbox Backwards Compatibility<br/>
    <small>Current Game Count: {$games|count}</small>
</h1>
</div>

{include file="./feeds.tpl"}
{include file="./faq.tpl"}

<div id="games">
    <div class="row input-group">
        <input class="form-control search" placeholder="Search" />
        <span class="input-group-btn">
            <button class="hidden-xs btn btn-default sort" data-sort="title">Sort by title</button>
            <button class="hidden-xs btn btn-default sort" data-sort="release">Sort by release</button>

            <button type="button" class="visible-xs btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="caret"></span>
                <span class="sr-only">Toggle Sort Options</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-right">
                <li><a href="#" data-sort="title" class="sort">Sort by title</a></li>
                <li><a href="#" data-sort="release" class="sort">Sort by release</a></li>
            </ul>
        </span>
    </div>

    <div class="row list">
        {foreach $games as $game}
            {include file="./game.tpl"}
        {/foreach}
    </div>
</div>

{/block}
