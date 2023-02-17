<x-app-layout>

    <x-slot name="pageTitle">
       Create Article 
    </x-slot>

    <div class="my-12 p-6 max-w-3xl mx-auto shadow bg-white rounded-lg">
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-6">
                <label for="title" class="block mb-2 text-sm font-medium text-gray-900 ">
                    Name
                </label>
                <input value="{{ old('name') }}" name="name" type="text" id="title" required maxlength="255"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">

                @error('name')
                    <p class="text-sm text-red-500"> {{ $message }} </p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="content" class="block mb-2 text-sm font-medium text-gray-900 ">
                    Email
                </label>
                <input type="email" name="email" value="{{old('email')}}" id="email" required maxlength="255" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " />
                @error('content')
                    <p class="text-sm text-red-500"> {{ $message }} </p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="cover_image" class="block mb-2 text-sm font-medium text-gray-900 ">
                    Password
                </label>
                <input name="password" type="password" id="password" required maxlength="30"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">

                @error('password')
                    <p class="text-sm text-red-500"> {{ $message }} </p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="cover_image" class="block mb-2 text-sm font-medium text-gray-900 ">
                    Role
                </label>
                <select name="role" type="role" id="role" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value=""></option>
                    @foreach ($listRoles as $role)
                    <option value="{{$role->name}}">{{$role->name}}</option>
                    @endforeach
                </select>

                @error('role')
                    <p class="text-sm text-red-500"> {{ $message }} </p>
                @enderror
            </div>

            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Submit</button>
        </form>
    </div>

</x-app-layout>
