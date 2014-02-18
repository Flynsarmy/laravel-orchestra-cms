@include('flynsarmy/orchestra-cms::backend.widgets.menu')

{{ Form::model($content, array('url' => $url, 'method' => $method, 'class' => 'form-horizontal')); }}

	<div class="row editor-buttons">
		<div class="six columns">
			<button class="btn btn-primary">
				<span class='glyphicon glyphicon-floppy-save'></span>
				Save
			</button>
			@if ( $content->exists)
				<a href="{{ $content->link }}" class="btn btn-info" target="_blank">
					<span class='glyphicon glyphicon-globe'></span>
					Preview
				</a>
			@endif
		</div>
		<div class="six columns text-right">
			<a href="{{ resources("orchestra-cms.pages") }}" class="btn btn-danger">
				<span class='glyphicon glyphicon-remove'></span>
				Cancel
			</a>
			@if ($content->exists)
				<a href="{{ resources("orchestra-cms.pages/{$content->id}/delete") }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this page?');">
					<span class='glyphicon glyphicon-trash'></span>
					Delete
				</a>
			@endif
		</div>
	</div>

	@if ( $errors->count() )
		<div class="alert alert-danger">
			{{ implode('<br/>', $errors->all()) }}
		</div>
	@endif

	<!-- Nav tabs -->
	<ul class="nav nav-tabs">
		<li class="active"><a href="#page-tabs-page" data-toggle="tab">Page</a></li>
		<li><a href="#page-tabs-meta" data-toggle="tab">Meta</a></li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane active" id="page-tabs-page">
			<fieldset>
				<div class="form-group{{ $errors->has('is_enabled') ? ' has-error': ' '; }}">
					<label class="two columns control-label" for="is_enabled">Enabled?</label>
					<div class="ten columns">
						{{ Form::hidden('is_enabled', 0) }} {{-- POST 0 if checkbox below not checked --}}
						{{ Form::checkbox('is_enabled', 1, array('id' => 'is_enabled', 'class' => 'form-control')); }}
						{{ $errors->first('is_enabled', '<p class="help-block error">:message</p>'); }}
					</div>
				</div>

				<div class="form-group{{ $errors->has('title') ? ' has-error': ' '; }}">
					<label class="two columns control-label" for="title">Title</label>
					<div class="ten columns">
						{{ Form::text('title', null, array('id' => 'title', 'class' => 'form-control')); }}
						{{ $errors->first('title', '<p class="help-block error">:message</p>'); }}
					</div>
				</div>

				<div class="form-group{{ $errors->has('slug') ? ' has-error': ' '; }}">
					<label class="two columns control-label" for="slug">Slug</label>
					<div class="ten columns">
						{{ Form::text('slug', null, array('role' => 'slug-editor', 'class' => 'form-control')); }}
						{{ $errors->first('slug', '<p class="help-block error">:message</p>'); }}
					</div>
				</div>

				<div class="form-group{{ $errors->has('template_id') ? ' has-error': ' '; }}">
					<label class="two columns control-label" for="template_id">Template</label>
					<div class="ten columns">
						{{ Form::select('template_id', $templates, null, array('id' => 'template_id', 'class' => 'form-control')); }}
						{{ $errors->first('template_id', '<p class="help-block error">:message</p>'); }}
					</div>
				</div>

				<div class="form-group{{ $errors->has('description') ? ' has-error': ' '; }}">
					<label class="two columns control-label" for="description">Description</label>
					<div class="ten columns">
						{{ Form::textarea('description', null, array('id' => 'description', 'class' => 'form-control')); }}
						{{ $errors->first('description', '<p class="help-block error">:message</p>'); }}
					</div>
				</div>

				<div class="form-group{{ $errors->has('content') ? ' has-error': ' '; }}">
					<div class="twelve columns">
						{{ Form::textarea('content', null, array('id' => 'content_field', 'class' => 'hide form-control')); }}
						{{ $errors->first('content', '<p class="help-block error">:message</p>'); }}
						<pre id="content_editor" class="ace huge" data-editor="ace" data-lang="twig" data-parent="#content_field"></pre>
					</div>
				</div>
			</fieldset>
		</div>
		<div class="tab-pane" id="page-tabs-meta">
			<fieldset>
				<div class="form-group{{ $errors->has('meta_description') ? ' has-error': ' '; }}">
					<label class="two columns control-label" for="meta_description">Description</label>
					<div class="ten columns">
						{{ Form::textarea('meta_description', null, array('id' => 'meta_description', 'class' => 'form-control')); }}
						{{ $errors->first('meta_description', '<p class="help-block error">:message</p>'); }}
					</div>
				</div>

				<div class="form-group{{ $errors->has('meta_keywords') ? ' has-error': ' '; }}">
					<label class="two columns control-label" for="meta_keywords">Keywords</label>
					<div class="ten columns">
						{{ Form::textarea('meta_keywords', null, array('id' => 'meta_keywords', 'class' => 'form-control')); }}
						{{ $errors->first('meta_keywords', '<p class="help-block error">:message</p>'); }}
					</div>
				</div>
			</fieldset>
		</div>
	</div>

{{ Form::close(); }}
