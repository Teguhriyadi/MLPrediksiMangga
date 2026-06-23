<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PredictController;
use App\Http\Controllers\ProduksiManggaController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VarietasManggaController;
use App\Models\User;
use Illuminate\Support\Facades\Route;


Route::get("/", function () {
    return redirect("/login");
});

Route::middleware(["web", "guest"])->group(function () {
    Route::prefix("login")->group(function () {
        Route::get("/", [LoginController::class, "login"]);
        Route::post("/", [LoginController::class, "post_login"]);
    });
});

Route::middleware(["web", "autentikasi"])->group(function () {
    Route::prefix("pages")->group(function () {
        Route::get("/dashboard", [AppController::class, "dashboard"])->middleware("role:" . implode(",", [
            User::ROLE_ADMIN,
            User::ROLE_OPERATOR,
            User::ROLE_PIMPINAN,
        ]));

        Route::prefix("machine")->group(function () {
            Route::post("/", [PredictController::class, "store"])->middleware("role:" . implode(",", [
                User::ROLE_ADMIN,
                User::ROLE_OPERATOR,
                User::ROLE_PIMPINAN,
            ]));
        });

        Route::prefix("laporan")->group(function () {
            Route::get("/", [LaporanController::class, "index"])->middleware("role:" . implode(",", [
                User::ROLE_ADMIN,
                User::ROLE_OPERATOR,
                User::ROLE_PIMPINAN,
            ]));
            Route::get("/excel", [LaporanController::class, "exportExcel"])->middleware("role:" . implode(",", [
                User::ROLE_ADMIN,
                User::ROLE_OPERATOR,
                User::ROLE_PIMPINAN,
            ]));
            Route::get("/pdf", [LaporanController::class, "exportPdf"])->middleware("role:" . implode(",", [
                User::ROLE_ADMIN,
                User::ROLE_OPERATOR,
                User::ROLE_PIMPINAN,
            ]));
        });

        Route::prefix("produksi-mangga")->group(function () {
            Route::get("/", [ProduksiManggaController::class, "index"])->middleware("role:" . implode(",", [
                User::ROLE_ADMIN,
                User::ROLE_OPERATOR,
                User::ROLE_PIMPINAN,
            ]));
            Route::get("/create", [ProduksiManggaController::class, "create"])->middleware("role:" . implode(",", [
                User::ROLE_ADMIN,
                User::ROLE_OPERATOR,
            ]));
            Route::post("/", [ProduksiManggaController::class, "store"])->middleware("role:" . implode(",", [
                User::ROLE_ADMIN,
                User::ROLE_OPERATOR,
            ]));
            Route::get("/{id}", [ProduksiManggaController::class, "show"])->middleware("role:" . implode(",", [
                User::ROLE_ADMIN,
                User::ROLE_OPERATOR,
                User::ROLE_PIMPINAN,
            ]));
            Route::get("/{id}/edit", [ProduksiManggaController::class, "edit"])->middleware("role:" . implode(",", [
                User::ROLE_ADMIN,
                User::ROLE_OPERATOR,
            ]));
            Route::put("/{id}", [ProduksiManggaController::class, "update"])->middleware("role:" . implode(",", [
                User::ROLE_ADMIN,
                User::ROLE_OPERATOR,
            ]));
            Route::delete("/{id}", [ProduksiManggaController::class, "destroy"])->middleware("role:" . implode(",", [
                User::ROLE_ADMIN,
                User::ROLE_OPERATOR,
            ]));
        });

        Route::prefix("users")->group(function() {
            Route::get("/", [UsersController::class, "index"])->middleware("role:" . User::ROLE_ADMIN);
            Route::post("/", [UsersController::class, "store"])->middleware("role:" . User::ROLE_ADMIN);
            Route::get("/{id}/edit", [UsersController::class, "edit"])->middleware("role:" . User::ROLE_ADMIN);
            Route::put("/{id}", [UsersController::class, "update"])->middleware("role:" . User::ROLE_ADMIN);
            Route::delete("/{id}", [UsersController::class, "destroy"])->middleware("role:" . User::ROLE_ADMIN);
        });

        Route::prefix("varietas-mangga")->group(function () {
            Route::get("/", [VarietasManggaController::class, "index"])->middleware("role:" . implode(",", [
                User::ROLE_ADMIN,
                User::ROLE_OPERATOR,
                User::ROLE_PIMPINAN,
            ]));
            Route::post("/", [VarietasManggaController::class, "store"])->middleware("role:" . implode(",", [
                User::ROLE_ADMIN,
                User::ROLE_OPERATOR,
            ]));
            Route::get("/{id}/edit", [VarietasManggaController::class, "edit"])->middleware("role:" . implode(",", [
                User::ROLE_ADMIN,
                User::ROLE_OPERATOR,
            ]));
            Route::put("/{id}", [VarietasManggaController::class, "update"])->middleware("role:" . implode(",", [
                User::ROLE_ADMIN,
                User::ROLE_OPERATOR,
            ]));
            Route::delete("/{id}", [VarietasManggaController::class, "destroy"])->middleware("role:" . implode(",", [
                User::ROLE_ADMIN,
                User::ROLE_OPERATOR,
            ]));
        });

        Route::get("/logout", [AppController::class, "logout"]);
    });
});
