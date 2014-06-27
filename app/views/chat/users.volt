{% if (users) %}
    <span class="frame-people view">
                            <ul class="roster">
                                {% for user in users %}
                                    <li>
                                        <div class="trpPeopleListItem view">
                                        <span>
                                            <div class="trpDisplayPicture {{ user.getStatus() }} avatar" style="background-image: url('{{ user.getUserAvatar() }}')" data-toggle="tooltip" data-original-title="{{ user.name }}">
                                                <div class="trpStatus" id="status" data-original-title="" title=""> </div>
                                            </div>
                                        </span>
                                        </div>
                                    </li>
                                {% endfor %}
                            </ul>
                        <div style="clear:both" />
                            <!--<a href="#people" class="trpMoreBadge" style="text-decoration: none">
                            div style="text-align: center;">See All</div></a><small>(27 members hidden)</small> -->
                        </span>
{% else %}
    <div>You can be the first of this chat</div>
{% endif %}