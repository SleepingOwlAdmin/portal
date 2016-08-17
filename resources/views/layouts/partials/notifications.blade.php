<aside class="ui sidebar vertical menu sidebar-notifications">
    <div class="ui inverted basic teal segment">
        <h4>
            <i class="alarm icon"></i>
            Notifications
        </h4>
    </div>
    <div class="ui basic segment" v-show="!hasNotifications">
        No
    </div>
    <div class="ui feed notification-item" v-show="hasNotifications" v-for="notification in notifications">
        <div class="event">
            <div class="label">
                <i class="circular @{{ notification.icon }} icon"></i>
            </div>
            <div class="content">
                <div class="summary">
                    @{{{ notification.text }}}
                </div>

                <div class="meta">
                    <div>
                        <small class="date">
                            @{{ notification.created_at | relative }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="ui divider"></div>
    </div>
</aside>