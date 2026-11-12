@extends('layouts.portal')

@section('title', 'Help & Support | UniCare')

@section('page-title', 'Help & support')
@section('page-subtitle', 'Answers to common questions and ways to reach us.')

@php
    $faqs = [
        'How do I book a counselling session?' =>
            'Go to New Appointment, choose what you would like to discuss, then pick a preferred date and time. Your request is sent to the counselling office for review.',
        'How will I know if my appointment is approved?' =>
            'Check My Appointments. The status changes from Pending to Approved once the counselling office confirms it. Approved sessions also appear on your dashboard.',
        'Can I change or cancel a request?' =>
            'Yes, while it is still Pending. Open My Appointments and use Edit or Cancel on that request. Once it is approved, contact the counselling office to make changes.',
        'Why was my request rejected?' =>
            'Open My Appointments and choose "View reason" on the rejected request. You are welcome to book another time.',
        'Is what I share confidential?' =>
            'Yes. Your appointment details are only visible to you and the counselling office.',
    ];
@endphp

@section('portal-content')

    <div class="dash-grid">
        <section class="help-card span-2" aria-labelledby="urgent-heading">
            <div class="help-icon">
                <svg aria-hidden="true" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg>
            </div>
            <h2 id="urgent-heading">Need help right now?</h2>
            <p>If you're in distress or feel unsafe, please don't wait for an appointment. Contact the campus helpline or emergency services immediately.</p>
            <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 4px">
                {{-- TODO: replace with your real numbers --}}
                <a href="#" class="btn btn-gold">Call [CAMPUS HELPLINE]</a>
                <a href="tel:999" class="btn btn-outline">Emergency: 999</a>
            </div>
        </section>

        <section class="card" aria-labelledby="contact-heading">
            <div class="card-header"><h2 id="contact-heading">Counselling office</h2></div>
            <div class="card-body">
                <dl class="info-list">
                    <dt>Email</dt><dd>[COUNSELLING CENTRE EMAIL]</dd>
                    <dt>Phone</dt><dd>[PHONE NUMBER]</dd>
                    <dt>Location</dt><dd>[OFFICE LOCATION]</dd>
                    <dt>Office hours</dt><dd>[e.g. Mon–Fri, 9:00 AM – 5:00 PM]</dd>
                </dl>
            </div>
        </section>
    </div>

    <section class="card" aria-labelledby="faq-heading">
        <div class="card-header"><h2 id="faq-heading">Frequently asked questions</h2></div>
        <div class="faq">
            @foreach ($faqs as $question => $answer)
                <details class="faq-item" @if ($loop->first) open @endif>
                    <summary>
                        {{ $question }}
                        <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                    </summary>
                    <p>{{ $answer }}</p>
                </details>
            @endforeach
        </div>
    </section>

    <section class="card" aria-labelledby="ready-heading">
        <div class="card-body" style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px">
            <div>
                <h2 id="ready-heading" style="font-size: 16px; font-weight: 600">Ready to talk to someone?</h2>
                <p class="field-hint" style="margin-top: 4px">Book a confidential session with the counselling office.</p>
            </div>
            <a href="{{ route('student.appointments.create') }}" class="btn btn-primary">Book an appointment</a>
        </div>
    </section>

@endsection