@include('flynsarmy/orchestra-cms::backend.widgets.menu')

{{ Form::model($content, array('url' => $url, 'method' => $method, 'class' => 'form-horizontal')); }}
	<fieldset>
		<div class="row editor-buttons">
			<div class="six columns">
				<button class="btn btn-primary">
					<span class='glyphicon glyphicon-floppy-save'></span>
					Save
				</button>
			</div>
			<div class="six columns text-right">
				<a href="{{ resources("orchestra-cms.templates") }}" class="btn btn-danger">
					<span class='glyphicon glyphicon-remove'></span>
					Cancel
				</a>
				@if ($content->exists)
					<a href="{{ resources("orchestra-cms.templates/{$content->id}/delete") }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this template?');">
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

		<div class="form-group{{ $errors->has('title') ? ' has-error': ' '; }}">
			<label class="two columns control-label" for="title">Title</label>
			<div class="ten columns">
				{{ Form::text('title', null, array('id' => 'title', 'class' => 'form-control')); }}
				{{ $errors->first('title', '<p class="help-block error">:message</p>'); }}
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
{{ Form::close(); }}
