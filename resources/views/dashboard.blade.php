{{-- https://github.com/BRACKETS-by-TRIAD/craftable --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- {{ __("You're logged in!") }} --}}
                    
                    <h1>Uploaded File</h1>
                    <br><br>
                        <table>
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Size</th>
                            <th scope="col">Type</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                            $counter = 1;
                            @endphp

                            
                            @foreach($files as $file)
                            <tr>
                                <td width="3%">{{ $counter++ }}</td>
                                <td>{{ $file->name }}</td>
                                <td width="10%">{{ $file->size }}</td>
                                <td width="10%">{{ $file->type }}</td>
                                <td width="5%">
                            </tr>
                            @endforeach
                            
                        </tbody>
                        </table>

                </div>
            </div>
        </div>
    </div>

    {{-- <div class="bg-light p-5 rounded">
        <h1>Files</h1>

        @include('layouts.partials.messages')

        <table>
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Size</th>
              <th scope="col">Type</th>
            </tr>
          </thead>
          <tbody>

            @php
            $counter = 1;
            @endphp

            
            @foreach($files as $file)
              <tr>
                <td width="3%">{{ $counter++ }}</td>
                <td>{{ $file->name }}</td>
                <td width="10%">{{ $file->size }}</td>
                <td width="10%">{{ $file->type }}</td>
                <td width="5%">
              </tr>
            @endforeach
            
          </tbody>
        </table>
    </div> --}}

</x-app-layout>
