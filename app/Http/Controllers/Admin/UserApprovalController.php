<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserApprovalController extends Controller
{
    /**
     * Display pending users for approval
     */
    public function index()
    {
        $pendingUsers = User::pending()
            ->with('roles')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.user-approvals.index', compact('pendingUsers'));
    }

    /**
     * Approve a user
     */
    public function approve(User $user)
    {
        if ($user->approval_status !== 'pending') {
            return back()->with('error', 'User ini sudah diproses sebelumnya.');
        }

        $user->update([
            'approval_status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'rejection_reason' => null,
        ]);

        // TODO: Send email notification to user

        return back()->with('success', "Akun {$user->name} ({$user->email}) berhasil disetujui.");
    }

    /**
     * Reject a user
     */
    public function reject(Request $request, User $user)
    {
        $request->validate([
            'rejection_reason' => ['required', 'string', 'max:500'],
        ]);

        if ($user->approval_status !== 'pending') {
            return back()->with('error', 'User ini sudah diproses sebelumnya.');
        }

        $user->update([
            'approval_status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        // TODO: Send email notification to user

        return back()->with('success', "Akun {$user->name} ({$user->email}) ditolak.");
    }

    /**
     * Show all approved users
     */
    public function approved()
    {
        $approvedUsers = User::approved()
            ->with(['roles', 'approver'])
            ->orderBy('approved_at', 'desc')
            ->paginate(20);

        return view('admin.user-approvals.approved', compact('approvedUsers'));
    }

    /**
     * Show all rejected users
     */
    public function rejected()
    {
        $rejectedUsers = User::where('approval_status', 'rejected')
            ->with(['roles', 'approver'])
            ->orderBy('approved_at', 'desc')
            ->paginate(20);

        return view('admin.user-approvals.rejected', compact('rejectedUsers'));
    }
}
