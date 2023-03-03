<footer>
    <p>Powered by
        <a>{{ $systemPresenter->getKeyValue('blog_name') }}</a>
        @if($systemPresenter->getKeyValue('icp'))
            <a href="https://beian.miit.gov.cn" target="_blank">{{ $systemPresenter->getKeyValue('icp') }}</a>
        @endif
        &nbsp;
        {!! $systemPresenter->getKeyValue('statistics_script') !!}
    </p>
</footer>
<a href="#" class="cd-top">Top</a>
