<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('News') }} ({{$pagination['items']}})
        </h2>
        <h5>./artisan app:news-parse</h5>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @php
                        /** @var \App\Models\NewList[] $news */
                    @endphp
                    @foreach ($news as $new)
                        <div style="border-bottom: 1px solid #000; padding-bottom: 1em">
                            <p>
                                <h3>{{$new->title}}</h3>
                                <b>{{$new->date}}</b>
                                <b>Rating {{$new->rating}}</b>
                            </p>
                            <p>{{$new->description}}</p>
                            @foreach ($new->getTags() as $tag)
                                <b>{{$tag->title}}</b>,
                            @endforeach
                            @if($new->getFile())
                                <img src="{{$new->getFile()->getUri()}}" alt="image">
                            @endif
                            <x-nav-link :href="route('news:like', ['page' => $pagination['page'], 'id' => $new->id])" :active="request()->routeIs('news')">like</x-nav-link>
                            <x-nav-link :href="route('news:dislike', ['page' => $pagination['page'], 'id' => $new->id])" :active="request()->routeIs('news')">dislike</x-nav-link>
                        </div>
                    @endforeach
                </div>

                <div class="p-6 text-gray-900">
                    @if($pagination['page'] > 1)
                        <x-nav-link :href="route('news', ['page' => ($pagination['page'] - 1)])"
                                    :active="request()->routeIs('news')">&lt;</x-nav-link>
                    @endif
                    <span>{{$pagination['page']}}</span>
                    @if($pagination['page'] < $pagination['pages'])
                        <x-nav-link :href="route('news', ['page' => ($pagination['page'] + 1)])"
                                    :active="request()->routeIs('news')">&gt;</x-nav-link>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
