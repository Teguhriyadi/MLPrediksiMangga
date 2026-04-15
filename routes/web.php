<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PredictController;
use App\Http\Controllers\ProduksiManggaController;
use App\Http\Controllers\UsersController;
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
        Route::get("/dashboard", [AppController::class, "dashboard"]);

        Route::prefix("machine")->group(function () {
            Route::post("/", [PredictController::class, "store"]);
        });

        Route::prefix("produksi-mangga")->group(function () {
            Route::get("/", [ProduksiManggaController::class, "index"]);
            Route::post("/", [ProduksiManggaController::class, "store"]);
            Route::get("/{id}/edit", [ProduksiManggaController::class, "edit"]);
            Route::put("/{id}", [ProduksiManggaController::class, "update"]);
            Route::delete("/{id}", [ProduksiManggaController::class, "destroy"]);
        });

        Route::prefix("users")->group(function() {
            Route::get("/", [UsersController::class, "index"]);
            Route::post("/", [UsersController::class, "store"]);
            Route::get("/{id}/edit", [UsersController::class, "edit"]);
            Route::put("/{id}", [UsersController::class, "update"]);
            Route::delete("/{id}", [UsersController::class, "destroy"]);
        });

        Route::get("/logout", [AppController::class, "logout"]);
    });
});
