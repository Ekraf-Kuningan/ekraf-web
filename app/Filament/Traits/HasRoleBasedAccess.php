<?php

namespace App\Filament\Traits;

use Illuminate\Support\Facades\Auth;

trait HasRoleBasedAccess
{
    /**
     * Get the navigation group for the resource based on user role
     */
    public static function getNavigationGroup(): ?string
    {
        $user = Auth::user();
        
        // Admin sees resources under "Master Data" group
        if ($user && $user->isAdmin()) {
            return 'Master Data';
        }
        
        // Superadmin sees the original navigation group
        // This will use the $navigationGroup property defined in each resource
        return static::$navigationGroup ?? null;
    }
    
    /**
     * Check if resource should be visible in navigation for current user
     */
    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();
        
        // Superadmin has access to everything
        if ($user && $user->isSuperAdmin()) {
            return true;
        }
        
        // Admin only has access to specific resources
        if ($user && $user->isAdmin()) {
            return in_array(static::class, static::getAdminAllowedResources());
        }
        
        return false;
    }
    
    /**
     * Get list of resources that admin role can access
     */
    protected static function getAdminAllowedResources(): array
    {
        return [
            \App\Filament\Resources\ProductResource::class,
            \App\Filament\Resources\MitraResource::class,
        ];
    }
    
    /**
     * Check if user can access this resource
     */
    public static function canAccess(): bool
    {
        $user = Auth::user();
        
        // Superadmin has full access
        if ($user && $user->isSuperAdmin()) {
            return true;
        }
        
        // Admin only has access to specific resources
        if ($user && $user->isAdmin()) {
            return in_array(static::class, static::getAdminAllowedResources());
        }
        
        return false;
    }
    
    /**
     * Check if user can view any records
     */
    public static function canViewAny(): bool
    {
        return static::canAccess();
    }
    
    /**
     * Check if user can create records
     */
    public static function canCreate(): bool
    {
        $user = Auth::user();
        
        // Superadmin can create everything
        if ($user && $user->isSuperAdmin()) {
            return true;
        }
        
        // Admin can create products
        if ($user && $user->isAdmin()) {
            if (static::class === \App\Filament\Resources\ProductResource::class) {
                return true; // Admin can add new products
            }
            return false; // Cannot create other resources
        }
        
        return false;
    }
    
    /**
     * Check if user can edit records
     */
    public static function canEdit($record): bool
    {
        $user = Auth::user();
        
        // Superadmin can edit everything
        if ($user && $user->isSuperAdmin()) {
            return true;
        }
        
        // Admin can only edit status (approve/reject) for products
        if ($user && $user->isAdmin()) {
            if (static::class === \App\Filament\Resources\ProductResource::class) {
                return true; // Can approve/reject products
            }
            if (static::class === \App\Filament\Resources\MitraResource::class) {
                return true; // Can view mitra details
            }
            return false;
        }
        
        return false;
    }
    
    /**
     * Check if user can delete records
     */
    public static function canDelete($record): bool
    {
        $user = Auth::user();
        
        // Only Superadmin can delete
        if ($user && $user->isSuperAdmin()) {
            return true;
        }
        
        // Admin cannot delete anything
        return false;
    }
    
    /**
     * Check if user can delete multiple records
     */
    public static function canDeleteAny(): bool
    {
        $user = Auth::user();
        
        // Only Superadmin can bulk delete
        return $user && $user->isSuperAdmin();
    }
}
