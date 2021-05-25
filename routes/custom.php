<?php

Route::get('/{slug}', [DocumentController::class, 'index'])->name('image');
