{%- if (messages) -%}
    {% for message in messages %}
        {% include "chat/message.volt" %}
    {% endfor %}
{%- else -%}
    <div>Your message will be the first...</div>
{%- endif -%}