@include('flynsarmy/orchestra-cms::backend.widgets.menu')

<?

use Illuminate\Support\Facades\Auth;
use Orchestra\Support\Facades\Acl;
use Orchestra\Support\Facades\Site;
use Orchestra\Support\Str;

$acl  = Acl::make('flynsarmy/orchestra-cms');
$auth = Auth::user();

if ($acl->can("create page") or $acl->can("manage page")) :
	Site::set('header::add-button', true);
endif; ?>

<div class="row">
	<div class="twelve columns white rounded box">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>{{ link_to(sort_contents_by_link('pages', 'title', 'desc'), 'Title') }}</th>
					<th>{{ link_to(sort_contents_by_link('pages', 'slug', 'asc'), 'URL') }}</th>
					<th>{{ link_to(sort_contents_by_link('pages', 'description', 'asc'), 'Description') }}</th>
					<th>Template</th>
					<th>Author</th>
					<th class="th-actions">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
			@if ($contents->isEmpty())
				<tr>
					<td colspan="6">No records at the moment.</td>
				</tr>
			@else
			@foreach ($contents as $content)
				<? $owner = ($content->user_id === $auth->id); ?>
				<tr class="{{ $content->is_enabled ? '' : 'disabled' }}">
					<td>
						<strong>
							@if ($acl->can("manage page") or ($owner and $acl->can("update page")))
								<a href="{{ resources("orchestra-cms.pages/{$content->id}/edit") }}">
									{{{ $content->title }}}
								</a>
							@else
								{{{ $content->title }}}
							@endif
						</strong>
					</td>
					<td>{{{ $content->slug }}}</td>
					<td>{{{ $content->description }}}</td>
					<td>{{{ $content->template->title }}}</td>
					<td>{{{ $content->author->fullname }}}</td>
					<td>
						<div class="btn-group">
							@if ($acl->can("manage page") or ($owner and $acl->can("delete page")))
								<a href="{{ resources("orchestra-cms.pages/{$content->id}/delete") }}" class="btn btn-mini btn-danger" onclick="return confirm('Are you sure you want to delete this page?');">
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
