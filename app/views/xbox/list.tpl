{extends file="./elements/layout.tpl"}

{block name=body}

<h1>Weekly Backwards Compatibility</h1>
<p>Current Game Count: {$games|count}</p>

{include file="./feeds.tpl"}

<div id="games" class="row">
    <div class="input-group">
        <input class="form-control search" placeholder="Search" />
        <span class="input-group-btn">
            <button class="btn btn-primary sort" data-sort="title">Sort by title</button>
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <th>Title</th>
                <th>Date added</th>
            </thead>

            <tbody class="list">
                {foreach $games as $game}
                <tr data-slug="{$game.slug}">
                    <td class="title"><a href="{$game.url}" target="_blank" rel="nofollow noreferrer">{$game.name}</a></td>
                    <td class="date">{$game.date_imported|DateTime}</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
</div>

{/block}
