<x-app-layout>

    <x-slot name="pageTitle">
       Create Role
    </x-slot>

    <div class="my-12 p-6 max-w-3xl mx-auto shadow bg-white rounded-lg">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @if(Session::has('error'))
    <p class="alert alert-danger">{{ Session::get('error') }}</p>
    @endif
    @if(Session::has('success'))
    <p class="alert alert-success">{{ Session::get('success') }}</p>
    @endif
        <form action="{{ route('roles.update', $role->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <label class="col-lg-6 col-sm-6 col-md-4 col-12">
                    Role Name
                </label>
                <input type="text" name="role_name" value="{{$role->name}}" required />
                @foreach (config('role') as $key => $value)
                <div class="col-lg-6 col-sm-6 col-md-4 col-12">
                <h2 style="color:red">{{ $key }}</h2>
                    @foreach($value['permissions'] as $index => $permission)
                    <div class="form-group">
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900 ">
                            {{ $permission }}
                        </label>
                        <input type="checkbox" name="{{ $index }}" class="form-control" <?php if (in_array($index, $listPermissions)) echo 'checked'; ?> />
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Submit</button>
        </form>
    </div>

</x-app-layout>
