# Webhook Integration (ITOMIG GmbH)

## Features
This module adds the capability to [iTop](https://github.com/Combodo/iTop) to send notifications based on actions and triggers to collaboration tools via webhook such as [Rocket Chat](https://rocket.chat/).

By default the only available kind of action consists in sending email. This itop extension defines a new types of Action:  Slack Notification and Rocket Chat Notification (Both based on Webhook Notification). You are able to:

* Send notifications to Slack or Rocket Chat
* Configure the target of the notification (workspace, channel, person)
* Configure display bot name of the incoming notification in Slack or Rocket Chat
* Format the messages by adding Headlines, links, edit the color etc.
* notice and react faster to changes in your iTop

## Revision History

| Version  | Release Date | Comments         | 
| -------- | ------------ | ---------------- |
| 17.4.0   | 2017-12-20   | Initial release. | 
| 18.1.0   | 2018-02-16   | Integration for Rocket Chat. | 
| 18.3.0   | 2018-02-16   | Code Refactoring to make extension more flexible. Support of Async notifications. | 
| 19.3.0   | 2019-09-30   | Integrate more information from iTop direct in your Notification. Thanks to @Hipska for contribution. |
| 19.3.1   | 2020-01-10   | Add some missing translations |
| 21.1.0   | 2021-03-17   | Fix invalid Block for Slack notifications and support more cases for iTop editor. Thanks to @Hipska for contribution. |

## Limitations

# This extension has become obsolete with version 3.0. To upgrade to 3.0, you need to uninstall this extension.

While iTop works with HTML to format messages, Slack uses an own markdown like language. This extensions transform HTML to markdown. But due to the limitations of the slack markdown currently images will not send to Slack and headings will only be displayed as bold.

## Requirements

* Existing Slack workspace or RocketChat Server
* Configured webhook
* URL of the webhook (for Slack it looks like: https://hooks.slack.com/services/T00000000/B00000000/XXXXXXXXXXXXXXXXXXXXXXXX )

## Installation

Use the Standard installation process of iTop for this extension.
Check Webhook Integration (ITOMIG GmbH) in the list of extensions at the end of the interactive wizard.

## Configuration

| Parameter         | Type    | Description | Default value |
| ----------------- | ------- | ----------- | ------------- |
| certificate_check | boolean | Whether to check the ssl certificate of slack server. | `true` |
| certificate_file  | string  | Path to an custom certificate file. | `''` |
| timeout           | integer | Determine how many seconds iTop shall wait for a response of Slack. | `5` |
| asynchronous      | boolean | Whether to send notifications asynchronous (cronjob must be configured in this case). | `false` |

## Usage

Slack Notification is a special type of Action. It is based on Action/Triggers. The usage is quite similar to an email notification.
To view and configure your Slack or RocketChat notifications use the link “Notifications” in the “Admin tools” menu and click on the tab “Actions”.
