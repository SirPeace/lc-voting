<div>
    @if ($comments->isNotEmpty())
        <div class="comments-container relative space-y-6 md:ml-22 pt-4 my-8 mt-1">
            @foreach ($comments as $comment)
                <livewire:idea-comment :comment="$comment" />
            @endforeach
        </div> <!-- end comments-container -->
    @else
        shit
    @endif
</div>
