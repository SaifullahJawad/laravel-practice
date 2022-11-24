<x-dropdown>

    <x-slot name="trigger">
        <button class="py-2 pl-3 pr-9 text-sm font-semibold w-full lg:w-32 text-left flex lg:inline-flex">

            {{ isset($currentCategory) ? ucwords($currentCategory->name) : 'Category' }}

            <x-icon name="down-arrow" class="absolute pointer-events-none" style="right: 12px;" />

        </button>
    </x-slot>

    <x-dropdown-item href="/?{{ http_build_query(request()->except('category', 'page')) }}" 
        :active="request()->routeIs('home')">All
    </x-dropdown-item>

    @foreach ($categories as $category)
        <x-dropdown-item 
            href="/?category={{ $category->slug }}&{{ http_build_query(request()->except('category', 'page')) }}" {{--request()->except('category') is gonna return an array except category, http_build_query() turns an array into query string. Like ['name' => 'john', 'age' => 24] becomes name=john&age=24 --}}
            :active='request()->is("categories/{$category->slug}")' {{--the prop will have either true of flase as its value--}}
        >{{ ucwords($category->name) }}</x-dropdown-item> {{--ucwords() turns the first letter of a word into a uppercase one--}}



    {{-- {{ isset($currentCategory) && $currentCategory->is($category) ? 'bg-blue-500 text-white' : '' }}--}}  {{--is method checks the ids of the variables in order to find out whether the two variables are the same or not. It basically does this: $currentCategory->id === $category->id --}}
                
    @endforeach
</x-dropdown>
