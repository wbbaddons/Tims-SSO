{if $sso|isset}
	{foreach from=$ssoAbbreviations item='ssoAbbreviation'}
		<img src="{link application=$ssoAbbreviation controller='SSO' data=$ssoData}{/link}" alt="" />
	{/foreach}
{/if}