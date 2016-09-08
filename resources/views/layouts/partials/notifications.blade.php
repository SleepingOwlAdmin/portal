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
        @{{{ notification.html }}}
        <div class="ui divided"></div>
    </div>
</aside>