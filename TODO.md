# TODO - StreetSole Laravel Fix

## Step 1: Audit & Plan Confirmation
- [x] Read routes/controllers/middleware/blade and migrations to map DB schema.
- [x] Approve implementation plan.

## Step 2: Implement Auth + Role Middleware
- [x] Implement AuthController: register/login, password hashing, redirect by role.

- [x] Implement RoleMiddleware: enforce role-based access.

- [x] Update routes/web.php: login/register/dashboard routes using controllers + middleware.


## Step 3: Implement DashboardController
- [x] Implement DashboardController@index: fetch products + admin datasets and pass to views.


## Step 4: Update Blade Files to Use DB Data
- [x] Update resources/views/login.blade.php: submit forms to Laravel routes.

- [x] Update resources/views/dashboard.blade.php: remove hardcoded products array; inject $products into JS.



- [x] Update resources/views/dashboard_admin.blade.php: remove hardcoded datasets; inject $products/$users/$orders/$reviews.


## Step 5: Validate
- [ ] Run basic checks (php artisan route:list, php artisan view:cache)
- [ ] Manual browser test: register/login, access /dashboard/pembeli and /dashboard/admin.

