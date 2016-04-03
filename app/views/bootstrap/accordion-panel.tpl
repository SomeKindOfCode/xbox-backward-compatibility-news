{assign var="current_count" value="{counter}" nocache}

<div class="panel panel-default">
	<div class="panel-heading" id="heading{$current_count}" role="tab">
		<h4 class="panel-title">
			<a aria-controls="collapse{$current_count}" aria-expanded="true" data-parent="#accordion" data-toggle="collapse" href="#collapse{$current_count}" role="button">
				{$title}
			</a>
		</h4>
	</div>
	<div aria-labelledby="heading{$current_count}" class="panel-collapse collapse" id="collapse{$current_count}" role="tabpanel">
		<div class="panel-body">
			{$text}
		</div>
	</div>
</div>
