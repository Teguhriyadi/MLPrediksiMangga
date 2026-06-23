<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PredictController;
use App\Http\Controllers\ProduksiManggaController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VarietasManggaController;
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

        Route::prefix("laporan")->group(function () {
            Route::get("/", [LaporanController::class, "index"]);
            Route::get("/excel", [LaporanController::class, "exportExcel"]);
            Route::get("/pdf", [LaporanController::class, "exportPdf"]);
        });

        Route::prefix("produksi-mangga")->group(function () {
            Route::get("/", [ProduksiManggaController::class, "index"]);
            Route::get("/create", [ProduksiManggaController::class, "create"]);
            Route::post("/", [ProduksiManggaController::class, "store"]);
            Route::get("/{id}", [ProduksiManggaController::class, "show"]);
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

        Route::prefix("varietas-mangga")->group(function () {
            Route::get("/", [VarietasManggaController::class, "index"]);
            Route::post("/", [VarietasManggaController::class, "store"]);
            Route::get("/{id}/edit", [VarietasManggaController::class, "edit"]);
            Route::put("/{id}", [VarietasManggaController::class, "update"]);
            Route::delete("/{id}", [VarietasManggaController::class, "destroy"]);
        });

        Route::get("/logout", [AppController::class, "logout"]);
    });
});
