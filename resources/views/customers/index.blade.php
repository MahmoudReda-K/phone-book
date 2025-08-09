<!DOCTYPE html>
<html>
<head>
    <title>Phone Numbers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.css">
</head>
<body>
<h1>Phone Numbers</h1>

<form method="GET" action="{{ route('customers.index') }}" class="mb-4">
    <div class="form-row align-items-end">
        <div class="col-md-4">
            <label for="country">Country</label>
            <select id="country" name="country" class="form-control">
                <option value="">All</option>
                @foreach($countries as $country)
                    <option value="{{ $country }}" {{ request('country') == $country ? 'selected' : '' }}>
                        {{ $country }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label for="state">State</label>
            <select id="state" name="state" class="form-control">
                <option value="">All</option>
                <option value="Valid" {{ request('state') == 'Valid' ? 'selected' : '' }}>Valid</option>
                <option value="Invalid" {{ request('state') == 'Invalid' ? 'selected' : '' }}>Invalid</option>
            </select>
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary btn-block">Filter</button>
        </div>
    </div>
</form>
<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Country</th>
        <th>Country Code</th>
        <th>Phone</th>
        <th>State</th>
    </tr>
    </thead>
    <tbody>
    @foreach($customers as $customer)
        <tr>
            <td>{{ $customer->name }}</td>
            <td>{{ $customer->country ?? 'Unknown' }}</td>
            <td>{{ $customer->country_code ?? '-' }}</td>
            <td>{{ $customer->phone }}</td>
            <td>{{ $customer->state }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $customers->links('pagination::bootstrap-4') }}
</body>
</html>
