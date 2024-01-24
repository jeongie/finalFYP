{{-- https://github.com/BRACKETS-by-TRIAD/craftable --}}

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha512-MoRNloxbStBcD8z3M/2BmnT+rg4IsMxPkXaGh2zD6LGNNFE80W3onsAhRcMAMrSoyWL9xD7Ert0men7vR8LUZg==" crossorigin="anonymous" />

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

                  <iframe title="sqlservertest1" width="900" height="573.5" src="https://app.powerbi.com/view?r=eyJrIjoiYjFlMDA5N2UtN2NkMy00MmZmLTgyNmYtYzM1NDYyOGQwOWFkIiwidCI6ImE2M2JiMWE5LTQ4YzItNDQ4Yi04NjkzLTMzMTdiMDBjYTdmYiIsImMiOjEwfQ%3D%3D" frameborder="0" allowFullScreen="true"></iframe>
                  <P STYLE="font: 10pt; margin: 12pt 0 0;"><I>The dashboard updates every hour.</I></P>
                    <br><br>
                    <table>
                      <h1 style="font-weight:bold; font-size:150%">Uploaded File</h1>
                      <br>
                      <thead>
                          <tr>
                          <td style="font-weight:bold">#</th> 
                          <td style="font-weight:bold">Name</th>
                          </tr>
                      </thead>
                      <tbody>

                          @php
                          $counter = 1;
                          @endphp

                          
                          @foreach($files as $file)
                          <tr>
                              <td width="2%">{{ $counter++ }}</td>
                              <td width="2%">{{ $file->name }}</td>
                              <td width="5%">
                            </tr>
                          @endforeach
                          
                      </tbody>
                    </table>
                   
                  <br><a href="{{ route('export.excel') }}" class="btn btn-primary mb-3">Export All</a>
              </div>
          </div>
      </div>
  </div>


</x-app-layout>