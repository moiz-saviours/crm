<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use App\Models\Email;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class InboxController extends Controller
{
    /**
     * Display the inbox index page with all email sections
     */
    public function index()
    {
        $emails = Email::all();
        $sections = $this->renderAllSectionsInSingleOperation($emails);
        return view('admin.customers.inbox.index', compact('emails', 'sections'));
    }

    /**
     * Render all sections in a single operation with one loop through emails
     */
    private function renderAllSectionsInSingleOperation(Collection $emails): array
    {
        $sectionHtml = ['unassigned' => '', 'assigned_to_me' => '', 'read' => '', 'all' => '', 'trashed' => '', 'sent' => '', 'spam' => '', 'unread' => '',];
        $counters = ['unassigned' => 0, 'assigned_to_me' => 0, 'read' => 0, 'all' => 0, 'trashed' => 0, 'sent' => 0, 'spam' => 0, 'unread' => 0,];
        foreach ($emails as $index => $email) {
            $emailHtml = View::make('admin.customers.inbox.partials.email-list', [
                'email' => $email,
                'isFirst' => $index === 0
            ])->render();
            $sectionHtml['all'] .= $emailHtml;
            $counters['all']++;
            if ($email->assigned_to === null) {
                $sectionHtml['unassigned'] .= $emailHtml;
                $counters['unassigned']++;
            }
            if ($email->assigned_to === Auth::id()) {
                $sectionHtml['assigned_to_me'] .= $emailHtml;
                $counters['assigned_to_me']++;
            }
            if ($email->is_read) {
                $sectionHtml['read'] .= $emailHtml;
                $counters['read']++;
            } else {
                $sectionHtml['unread'] .= $emailHtml;
                $counters['unread']++;
            }
            if ($email->is_trashed) {
                $sectionHtml['trashed'] .= $emailHtml;
                $counters['trashed']++;
            }
            if ($email->type === 'outgoing' && $email->folder === 'sent') {
                $sectionHtml['sent'] .= $emailHtml;
                $counters['sent']++;
            }
            if ($email->is_spam) {
                $sectionHtml['spam'] .= $emailHtml;
                $counters['spam']++;
            }
        }
        return [
            'unassigned' => [
                'email_list' => $counters['unassigned'] === 0 ? $this->renderEmptyState('fas fa-box-open', 'No unassigned conversations') : $sectionHtml['unassigned'],
                'count' => $counters['unassigned']
            ],
            'assigned_to_me' => [
                'email_list' => $counters['assigned_to_me'] === 0 ? $this->renderEmptyState('fas fa-user-check', 'No assigned conversations') : $sectionHtml['assigned_to_me'],
                'count' => $counters['assigned_to_me']
            ],
            'read' => [
                'email_list' => $counters['read'] === 0 ? $this->renderEmptyState('fas fa-envelope-open', 'No read conversations') : $sectionHtml['read'],
                'count' => $counters['read']
            ],
            'all' => [
                'email_list' => $counters['all'] === 0 ? $this->renderEmptyState('fas fa-box-open', 'No conversations') : $sectionHtml['all'],
                'count' => $counters['all']
            ],
            'trashed' => [
                'email_list' => $counters['trashed'] === 0 ? $this->renderEmptyState('fas fa-trash', 'No trash conversations') : $sectionHtml['trashed'],
                'count' => $counters['trashed']
            ],
            'sent' => [
                'email_list' => $counters['sent'] === 0 ? $this->renderEmptyState('fas fa-paper-plane', 'No sent conversations') : $sectionHtml['sent'],
                'count' => $counters['sent']
            ],
            'spam' => [
                'email_list' => $counters['spam'] === 0 ? $this->renderEmptyState('fas fa-ban', 'No spam conversations') : $sectionHtml['spam'],
                'count' => $counters['spam']
            ],
            'unread' => [
                'email_list' => $counters['unread'] === 0 ? $this->renderEmptyState('fas fa-inbox', 'No unread conversations') : $sectionHtml['unread'],
                'count' => $counters['unread']
            ],
        ];
    }

    /**
     * Render empty state
     */
    private function renderEmptyState(string $icon, string $message): string
    {
        return View::make('admin.customers.inbox.partials.empty-state', [
            'icon' => $icon,
            'message' => $message
        ])->render();
    }

    /**
     * AJAX endpoint to render a specific section
     */
    public function getSection($section)
    {
        $emails = Email::all();
        $renderedSections = $this->renderAllSectionsInSingleOperation($emails);
        return response()->json(['html' => $renderedSections[$section] ?? '']);
    }
}
