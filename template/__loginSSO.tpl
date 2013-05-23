{if $sso|isset}
	{foreach from=$ssoAbbreviations item='ssoAbbreviation'}
		<img src="{link application=$ssoAbbreviation controller='SSO' cookies=$ssoCookies key=$ssoHMAC}{/link}" alt="" />
	{/foreach}
{/if}