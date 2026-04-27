@extends('layouts.app')

@section('title', 'إدارة الموظفين - جوازات اليمن')
@section('header_title', 'قائمة الموظفين المصرح لهم')

@section('content')
<div style="max-inline-size: 1100px; margin-inline: auto;">
    <div style="margin-block-end: var(--space-lg); display: flex; justify-content: space-between; align-items: center;">
        <h1 style="margin: 0; font-size: 1.5rem; color: var(--primary);">الموظفين</h1>
        <a href="{{ route('admin.employees.create') }}" class="btn-figma-gold" style="text-decoration: none; padding-inline: 24px;">
            <svg style="inline-size: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            إضافة موظف جديد
        </a>
    </div>

    <div class="table-container">
        <table class="table-figma">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>البريد الإلكتروني</th>
                    <th>تاريخ الانضمام</th>
                    <th style="text-align: center;">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="inline-size: 32px; block-size: 32px; border-radius: 50%; background: var(--accent); color: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8rem;">
                                {{ substr($employee->name, 0, 1) }}
                            </div>
                            <span style="font-weight: 600;">{{ $employee->name }}</span>
                        </div>
                    </td>
                    <td style="color: var(--text-muted);">{{ $employee->email }}</td>
                    <td style="color: var(--text-muted);">{{ $employee->created_at->format('Y/m/d') }}</td>
                    <td>
                        <div style="display: flex; justify-content: center; gap: 8px;">
                            <button title="تعديل" style="background: none; border: none; color: var(--text-muted); cursor: pointer;">
                                <svg style="inline-size: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            <button title="حذف" style="background: none; border: none; color: #EF4444; cursor: pointer;">
                                <svg style="inline-size: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="padding: 16px;">
            {{ $employees->links() }}
        </div>
    </div>
</div>
@endsection
