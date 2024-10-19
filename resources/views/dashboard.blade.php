@extends('components.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white active" href="{{ route('admin.dashboard') }}">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">
                            User Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">
                            Reports
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">
                            Settings
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Admin Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary">
                        <span data-feather="calendar"></span>
                        This week
                    </button>
                </div>
            </div>

            <!-- Dashboard Widgets -->
            <div class="row">
                <div class="col-lg-4">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">
                            Total Users
                            <h4>150</h4>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="text-white stretched-link" href="#">View Details</a>
                            <div class="text-white">
                                <i class="fas fa-angle-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">
                            Active Sessions
                            <h4>30</h4>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="text-white stretched-link" href="#">View Details</a>
                            <div class="text-white">
                                <i class="fas fa-angle-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body">
                            Pending Reports
                            <h4>5</h4>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="text-white stretched-link" href="#">View Details</a>
                            <div class="text-white">
                                <i class="fas fa-angle-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Dashboard Content -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            Recent Activity
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>User</th>
                                        <th>Action</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>2024-10-01</td>
                                        <td>John Doe</td>
                                        <td>Logged in</td>
                                        <td><span class="badge bg-success">Success</span></td>
                                    </tr>
                                    <tr>
                                        <td>2024-10-02</td>
                                        <td>Jane Smith</td>
                                        <td>Uploaded report</td>
                                        <td><span class="badge bg-warning">Pending</span></td>
                                    </tr>
                                    <!-- Add more rows as necessary -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
