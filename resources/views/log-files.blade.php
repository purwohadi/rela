<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="root-text-sm">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Log Viewer | {{ env('APP_NAME') }}</title>
    <!-- Styles -->
    <link href="{{ mix('css/theme.css') }}" rel="stylesheet">
</head>
<body>
  <main class="bd-content p-5" role="main">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-10">
          <h3 class="font-weight-bolder">Application Log Files</h3>
          <div class="mt-3">
            <table class="table table-md table-bordered table-striped">
              <thead class="thead-light">
                <tr>
                  <th class="font-weight-bold">#</th>
                  <th class="font-weight-bold">File Name</th>
                  <th class="font-weight-bold">Size</th>
                  <th class="font-weight-bold">Time</th>
                  <th class="font-weight-bold">Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse($logFiles as $key => $logFile)
                <tr>
                  <td>{{ $key + 1 }}</td>
                  <td>{{ $logFile->getFilename() }}</td>
                  <td>{{ $logFile->getSize() }}</td>
                  <td>{{ date('Y-m-d H:i:s', $logFile->getMTime()) }}</td>
                  <td>
                    <a href="{{ route('log-files.show', $logFile->getFilename()) }}"
                      title="Show file {{ $logFile->getFilename() }}">View</a> |
                    <a href="{{ route('log-files.download', $logFile->getFilename()) }}"
                      title="Download file {{ $logFile->getFilename() }}">Download</a>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="3">No Log File Exists</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>

</html>
