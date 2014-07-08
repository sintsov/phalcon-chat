<div class="row">
    <div class="leftPanel">
        <div class="panel panel-default">
            {%- if session.get('auth') -%}

                <!-- Profile -->
                <div class="panel-heading">
                    <h3 class="panel-title">Profile</h3>
                </div>
                <div class="panel-body" id="profileLeftPanel">
                    <div id="left-menu-profile" class="trpLeftMenuProfile"><div>
                            <div class="trpLeftMenuProfileHeader view">
                                <div class="trpDisplayPicture avatar" style="background-image: url('{{ user.getUserAvatar() }}')"></div>
                                <div class="trpLeftMenuProfileName">{{ user.name }}</div>
                            </div>
                        </div>
                    </div>
                    <div style="display:none" id="avatarLoad">
                        <span class="btn btn-success fileinput-button">
                              <i class="glyphicon glyphicon-plus"></i>
                              <span>Load avatar...</span>
                              <input id="fileupload" type="file" name="avatar" >
                        </span>
                    </div>
                    <div class="trpLeftMenuProfileButton">
                        <form action="/auth/singout/">
                            <input type="submit" class="form-control signout-button" value="SignOut"/>
                        </form>
                    </div>
                </div>

            {%- else -%}

                <div class="panel-body">
                    <!-- Sign In|Join -->
                    <div id="auth-head">
                        Welcome Phalcon-Chat project for Phalcon Framework Demo.
                    </div>
                    <div id="auth-panel">
                        <ul class="nav nav-tabs">
                            <li><a href="#login" data-toggle="tab">Log in</a></li>
                            <li><a href="#join">Join</a></li>
                        </ul>
                        <div class="tab-content">
                            {{ flashSession.output() }}
                            {% set token = security.getToken()  %}
                            <div class="tab-pane fade" id="login">
                                    {{ form('auth/signin', 'id': 'form-sigin') }}
                                    {{ forms.get('signForm').render('csrf', ['value': token]) }}
                                    <div class="form-group">
                                        {{ forms.get('signForm').render('email') }}
                                    </div>
                                    <div class="form-group">
                                        {{ forms.get('signForm').render('password') }}
                                    </div>
                                    {{ forms.get('signForm').render('Sign In') }}
                                    </form>
                            </div>
                            <div class="tab-pane fade" id="join">
                                {{ form('auth/join', 'id': 'form-join') }}
                                {{ forms.get('joinForm').render('csrf', ['value': token]) }}
                                <div class="form-group">
                                    {{ forms.get('joinForm').render('name') }}
                                </div>
                                <div class="form-group">
                                    {{ forms.get('joinForm').render('email') }}
                                </div>
                                <div class="form-group">
                                    {{ forms.get('joinForm').render('password') }}
                                </div>
                                <div class="form-group">
                                    {{ forms.get('joinForm').render('confirmPassword') }}
                                </div>
                                {{ forms.get('joinForm').render('Join') }}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            {%- endif -%}
        </div>
    </div>
    <div id="chat">
        <div class="trpHeaderWrapper" id="header-wrapper">
            <div class="trpHeaderArea" id="header">
                <div class="trpHeaderContainer">
                    <div class="trpTroupeFavourite" id="favourite-button">
                        <div style="display: inline-block; vertical-align: middle; width:26px; height:26px">
                            <span class="glyphicon glyphicon-star-empty"></span>
                        </div>
                    </div>
                    <div class="gtrNameTopic">
                        <h1 id="name-label">phalcon-chat</h1>
                        <p id="trpTopic">Chat test Phalcon Framework</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="trpChatContainer primary-scroll scroller" id="content-frame">
            {%  set messages = messages.getMessages() %}
            {% include "chat/messages.volt" %}
        </div>

    {%- if session.get('auth') -%}
        <div class="trpChatInputArea scrollpush form-inline" id="chat-input">
            <div class="trpChatInputContainer view">
                <div class="trpChatInputAvatar form-group">
	            <span>
                    <div class="trpDisplayPicture avatar" style="background-image: url('{{ user.getUserAvatar() }}')"></div></span>
                </div>
                <form class="trpChatInputBox" name="chat">
                    <div class="textcomplete-wrapper form-group" style="position: absolute;">
                        <textarea class="trpChatInputBoxTextArea scroller form-control" name="chat" id="chat-input-textarea" placeholder="Click here to type a chat message. ctrl+Enter to send." autofocus="autofocus" maxlength="4096" style="width: 720px; resize: none; overflow: hidden"></textarea>
                    </div>
                </form>
            </div>
        </div>
    {%- endif -%}

        <div class="trpToolbar">
            <div id="people-list">
                <div class="trpToolbarHeader" id="top-header">
                    <div class="trpToolbarHeaderItem selected" id="people-header">
                        People
                    </div>
                </div>
                <div class="trpToolbarList">
                    <div class="trpToolbarListContent" id="people-roster">
                        <div>
                            {% set users = users.getUsersList() %}
                            {% include "chat/users.volt" %}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>