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
            <button class="btn btn-default sort" data-sort="title">Sort by title</button>
            <button class="btn btn-default sort" data-sort="release">Sort by release</button>
        </span>
    </div>

    <div class="row list">
        {foreach $games as $game}
            {include file="./game.tpl"}
        {/foreach}
    </div>
</div>

{/block}
