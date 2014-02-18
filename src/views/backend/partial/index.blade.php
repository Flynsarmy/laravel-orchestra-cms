@include('flynsarmy/orchestra-cms::backend.widgets.menu')

<?

use Illuminate\Support\Facades\Auth;
use Orchestra\Support\Facades\Acl;
use Orchestra\Support\Facades\Site;
use Orchestra\Support\Str;

$acl  = Acl::make('flynsarmy/orchestra-cms');
$auth = Auth::user();

if ($acl->can("create partial") or $acl->can("manage partial")) :
	Site::set('header::add-button', true);
endif; ?>

<div class="row">
	<div class="twelve columns white rounded box">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Title</th>
					<th>Description</th>
					<th>Author</th>
					<th class="th-actions">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
			@if ($contents->isEmpty())
				<tr>
					<td colspan="4">No records at the moment.</td>
				</tr>
			@else
			@foreach ($contents as $content)
				<? $owner = ($content->user_id === $auth->id); ?>
				<? $status = Str::title($content->status); ?>
				<tr>
					<td>
						<strong>
							@if ($acl->can("manage partial") or ($owner and $acl->can("update partial")))
								<a href="{{ resources("orchestra-cms.partials/{$content->id}/edit") }}">
									{{{ $content->title }}}
								</a>
							@else
								{{{ $content->title }}}
							@endif
						</strong>
						<br>
						<span class="meta">
							<span class="label label-default">{{ Str::title($content->format) }}</span>
							<span class="label label-success">{{ Str::title($content->status) }}</span>
						</span>
					</td>
					<td>{{{ $content->description }}}</td>
					<td>{{{ $content->author->fullname }}}</td>
					<td>
						<div class="btn-group">
							@if ($acl->can("manage partial") or ($owner and $acl->can("delete partial")))
								<a href="{{ resources("orchestra-cms.partials/{$content->id}/delete") }}" class="btn btn-mini btn-danger" onclick="return confirm('Are you sure you want to delete this partial?');">
									Delete
								</a>
							@endif
						</div>
					</td>
				</tr>
			@endforeach
			@endif
			</tbody>
		</table>

		{{ $contents->links() }}
	</div>
</div>
