<footer class="footer mt-auto py-3" style="background: #2c3e50;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0 text-white small">
                    <i class="bi bi-shop me-1"></i> 
                    <strong>E-commerce Admin</strong> 
                    <span class="mx-2 opacity-75">•</span> 
                    © {{ date('Y') }}
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-0 text-white small">
                    <span class="badge bg-white bg-opacity-20 text-white px-2 py-1 border-0">v1.0</span>
                    <span class="ms-2 opacity-75">
                        <i class="bi bi-lightning-charge me-1"></i>Laravel {{ app()->version() }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</footer>