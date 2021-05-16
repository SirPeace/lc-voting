<div>
    <div class="idea-container bg-white rounded-xl flex mt-4">
        <div class="flex flex-col md:flex-row flex-1 px-4 py-6">
            <div class="flex-none mx-2 md:mx-2">
                <a href="#">
                    <img src="{{ $idea->user->getAvatar() }}" alt="avatar" class="w-14 h-14 rounded-xl">
                </a>
            </div>
            <div class="md:w-full mx-2 md:mx-4">
                <h4 class="text-xl font-semibold mt-2 md:mt-0">
                    {{ $idea->title }}
                </h4>
                <div class="text-gray-600 mt-3">
                    {{ $idea->description }}
                </div>

                <div class="flex flex-col md:flex-row md:items-center justify-between mt-6">
                    <div class="flex items-center text-xs text-gray-400 font-semibold space-x-2">
                        <div class="hidden md:block font-bold text-gray-900">{{ $idea->user->first_name }}</div>
                        <div class="hidden md:block">&bull;</div>
                        <div>{{ $idea->created_at->diffForHumans() }}</div>
                        <div>&bull;</div>
                        <div>{{ $idea->category->alias }}</div>
                        <div>&bull;</div>
                        <div class="text-gray-900">3 Comments</div>
                    </div>

                    <div class="flex justify-between mt-4 md:mt-0">
                        <div class="flex items-center md:hidden md:mt-0" x-data>
                            <div class="bg-gray-100 text-center rounded-xl h-10 px-4 py-2 pr-8">
                                <div class="text-sm font-bold leading-none @if ($isVoted) text-blue @endif">{{ $votesCount }}</div>
                                <div class="text-xxs font-semibold leading-none text-gray-400">Votes</div>
                            </div>

                            @if ($isVoted)
                                <button
                                    class="w-20 bg-blue hover:bg-blue-hover text-white font-bold text-xxs uppercase rounded-xl transition duration-150 ease-in px-4 py-3 -mx-5"
                                    wire:click="unvote"
                                >
                                    Voted
                                </button>
                            @else
                                <button
                                    class="w-20 bg-gray-200 border border-gray-200 font-bold text-xxs uppercase rounded-xl hover:border-gray-400 transition duration-150 ease-in px-4 py-3 -mx-5"
                                    wire:click="vote"
                                >
                                    Vote
                                </button>
                            @endif
                        </div>

                        <div
                            class="flex items-center space-x-2 md:mt-0"
                            x-data="{ isOpen: false }"
                        >
                            <div class="{{ $idea->status->getStylingClasses() }} text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 py-2 px-4">{{ $idea->status->alias }}</div>
                            <div class="relative">
                                <button
                                    class="relative bg-gray-100 hover:bg-gray-200 border rounded-full h-7 transition duration-150 ease-in py-2 px-3"
                                    @click="isOpen = !isOpen"
                                >
                                    <svg fill="currentColor" width="24" height="6"><path d="M2.97.061A2.969 2.969 0 000 3.031 2.968 2.968 0 002.97 6a2.97 2.97 0 100-5.94zm9.184 0a2.97 2.97 0 100 5.939 2.97 2.97 0 100-5.939zm8.877 0a2.97 2.97 0 10-.003 5.94A2.97 2.97 0 0021.03.06z" style="color: rgba(163, 163, 163, .5)"></svg>
                                </button>
                                <ul
                                    class="absolute w-44 text-left font-semibold bg-white shadow-dialog rounded-xl z-10 py-3 md:ml-8 top-8 md:top-6 right-0 md:left-0"
                                    x-cloak
                                    x-show.transition.origin.top.left="isOpen"
                                    @click.away="isOpen = false"
                                    @keydown.escape.window="isOpen = false"
                                >
                                    <li>
                                        <a
                                            href="#"
                                            class="hover:bg-gray-100 block transition duration-150 ease-in px-5 py-3"
                                            @click="
                                                isOpen = false
                                                $dispatch('custom-show-edit-modal')
                                            "
                                        >Edit idea</a>
                                    </li>
                                    <li><a href="#" class="hover:bg-gray-100 block transition duration-150 ease-in px-5 py-3">Mark as Spam</a></li>
                                    <li><a href="#" class="hover:bg-gray-100 block transition duration-150 ease-in px-5 py-3">Delete Post</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  <!-- end idea-container -->
    <div class="buttons-container flex items-center justify-between mt-6">
        <div class="w-full md:w-auto flex flex-col md:flex-row items-center md:space-x-4 md:ml-6">
            <div x-data="{ isOpen: false }" class="relative w-full">
                <button type="button" @click="isOpen = !isOpen" class="w-full flex items-center justify-center h-12 md:h-11 text-sm bg-blue text-white font-semibold rounded-xl border border-blue hover:bg-blue-hover transition duration-150 ease-in px-6 py-3">
                    Reply
                </button>
                <div class="absolute z-10 w-full md:w-104 text-left font-semibold text-sm bg-white shadow-dialog rounded-xl mt-2" @click.away="isOpen = false" @keydown.escape.window="isOpen = false" style="display: none;" x-show.transition.origin.top="isOpen">
                    <form action="#" class="space-y-4 px-4 py-6">
                        <div>
                            <textarea name="post_comment" id="post_comment" cols="30" rows="4" class="w-full text-sm bg-gray-100 rounded-xl placeholder-gray-900 border-none px-4 py-2" placeholder="Go ahead, don't be shy. Share your thoughts..."></textarea>
                        </div>

                        <div class="flex flex-row items-center space-x-3">
                            <button type="button" class="flex items-center justify-center h-11 w-1/2 text-sm bg-blue text-white font-semibold rounded-xl border border-blue hover:bg-blue-hover transition duration-150 ease-in px-6 py-3">
                                Post Comment
                            </button>
                            <button type="button" class="flex items-center justify-center w-1/2 md:w-32 h-11 text-xs bg-gray-200 font-semibold rounded-xl border border-gray-200 hover:border-gray-400 transition duration-150 ease-in px-6 py-3 mt-0">
                                <svg class="text-gray-600 w-4 transform -rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                </svg>
                                <span class="ml-1">Attach</span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
            @auth
                @if (auth()->user()->isAdmin())
                    <livewire:set-status :idea="$idea" />
                @endif
            @endauth
        </div>

        <div class="hidden md:flex items-center space-x-3">
            <div class="bg-white font-semibold text-center rounded-xl px-3 py-2">
                <div class="text-xl leading-snug @if ($isVoted) text-blue @endif">{{ $idea->votes()->count() }}</div>
                <div class="text-gray-400 text-xs leading-none">Votes</div>
            </div>

            @if ($isVoted)
                <button
                    wire:click="unvote"
                    type="button"
                    class="w-32 h-11 text-xs bg-blue hover:bg-blue-hover text-white border border-blue font-semibold uppercase rounded-xl  transition duration-150 ease-in px-6 py-3"
                >
                    Voted
                </button>
            @else
                <button
                    wire:click="vote"
                    type="button"
                    class="w-32 h-11 text-xs bg-gray-200 font-semibold uppercase rounded-xl border border-gray-200 hover:border-gray-400 transition duration-150 ease-in px-6 py-3"
                >
                    Vote
                </button>
            @endif
        </div>
    </div> <!-- end buttons-container -->
</div>
