<template>
  <div class="notif-menu">
    <a href="#" class="header-icon" data-toggle="dropdown" title="You got 2 notifications">
      <i class="fal fa-bell"></i>
      <span class="badge badge-icon">2</span>
    </a>
    <div class="dropdown-menu dropdown-menu-animated dropdown-xl">
      <div class="dropdown-header bg-trans-gradient d-flex justify-content-center align-items-center rounded-top mb-2">
        <h4 class="m-0 text-center color-white">
          2 New
          <small class="mb-0 opacity-80">User Notifications</small>
        </h4>
      </div>
      <ul class="nav nav-tabs nav-tabs-clean" role="tablist">
        <li class="nav-item active">
          <a class="nav-link px-4 fs-md js-waves-on fw-500" data-toggle="tab" href="#tab-messages" data-i18n="drpdwn.messages">Messages</a>
        </li>
      </ul>
      <div class="tab-content tab-notification">
        <div class="tab-pane" id="tab-messages" role="tabpanel">
          <div class="custom-scroll h-100">
            <ul class="notification">
              <li class="unread">
                <a href="#" class="d-flex align-items-center">
                  <span class="status mr-2">
                    <img src="img/user-f.png" alt="User Notification" class="profile-image rounded-circle">
                  </span>
                  <span class="d-flex flex-column flex-1 ml-1">
                    <span class="name">Melissa Ayre <span class="badge badge-primary fw-n position-absolute pos-top pos-right mt-1">INBOX</span></span>
                    <span class="msg-a fs-sm">Re: New security codes</span>
                    <span class="msg-b fs-xs">Hello again and thanks for being part...</span>
                    <span class="fs-nano text-muted mt-1">56 seconds ago</span>
                  </span>
                </a>
              </li>
              <li>
                <a href="#" class="d-flex align-items-center">
                  <span class="status mr-2">
                    <img src="img/user-f.png" alt="User Notification" class="profile-image rounded-circle d-inline-block">
                  </span>
                  <span class="d-flex flex-column flex-1 ml-1">
                    <span class="name">Adison Lee</span>
                    <span class="msg-a fs-sm">Msed quia non numquam eius</span>
                    <span class="fs-nano text-muted mt-1">2 minutes ago</span>
                  </span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="py-2 px-3 bg-faded d-block rounded-bottom text-right border-faded border-bottom-0 border-right-0 border-left-0">
        <a href="#" class="fs-xs fw-500 ml-auto">view all notifications</a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PartNotif'
}
</script>
