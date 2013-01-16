{if $sso|isset}
{foreach from=$ssoAbbreviations item='ssoAbbreviation'}
	<img src="{link application=$ssoAbbreviation controller='SSO'}s={$ssoSessionID}{/link}" alt="" />
{/foreach}
{/if}