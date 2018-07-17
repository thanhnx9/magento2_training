define(
    [
        'ko'
    ], function (ko) {
        'use strict';

        return {
            getStatusObject: function(){
                return [
                    {statusClass: 'pending', statusTitle: 'Pending', statusLabel: 'Pending'},
                    {statusClass: 'processing', statusTitle: 'Processing', statusLabel: 'Processsing'},
                    {statusClass: 'complete', statusTitle: 'Complete', statusLabel: 'Complete'},
                    {statusClass: 'canceled', statusTitle: 'Canceled', statusLabel: 'Cancelled'},
                    {statusClass: 'closed', statusTitle: 'Closed', statusLabel: 'Closed'},
                    {statusClass: 'notsync', statusTitle: 'Not Sync', statusLabel: 'Not Sync'}
                ]
            },

            getStatusObjectView: function(){
                return [
                    {statusClass: 'pending', statusTitle: 'Pending', statusLabel: 'Pending'},
                    {statusClass: 'processing', statusTitle: 'Processing', statusLabel: 'Processsing'},
                    {statusClass: 'complete', statusTitle: 'Complete', statusLabel: 'Complete'},
                    {statusClass: 'canceled', statusTitle: 'Canceled', statusLabel: 'Cancelled'},
                    {statusClass: 'closed', statusTitle: 'Closed', statusLabel: 'Closed'},
                    {statusClass: 'notsync', statusTitle: 'Not Sync', statusLabel: 'Not Sync'},
                    {statusClass: 'holded', statusTitle: 'On Hold', statusLabel: 'On Hold'},
                    {statusClass: 'onhold', statusTitle: 'On Hold', statusLabel: 'On Hold'}
                ];
            },

            getStatusArray: function(){
                return ['pending','processing','complete','canceled','closed','notsync', 'holded'];
            }
        }
    });
