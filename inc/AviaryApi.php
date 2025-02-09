<?php
class AviaryApi {

    private $username = 'lchen@nphm.org';
    private $password = '1322TaylorSt.';
    private $headers = [];
    private $supplementalFiles = [];

    private function __construct() {
        $this->headers = $this->authenticate();
        $this->loadSupplementalFiles();
    }

    private function authenticate(){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.aviaryplatform.com/api/v1/auth/sign_in');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array('email' => $this->username, 'password' => $this->password)));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_HEADER, true); // Include the headers in the output

        // Execute the request
        $response = curl_exec($ch);

        // Separate headers and body
        list($headers, $body) = explode("\r\n\r\n", $response, 2);

        curl_close($ch);

        $headersList = [];
        foreach(explode("\n",$headers) as $header){
            $explodedHeader = explode(":",$header);
            $key = $explodedHeader[0];
            $value = $explodedHeader[1] ?? '';
            $headersList[$key] = trim($value);
        }
        $body = json_decode($body,true);

        return [
            'access-token:'.$headersList['access-token'],
            'client:'.$headersList['client'],
            'uid:'.$headersList['uid'],
            'organization-id:'.$body['data']['organizations'][0]['id']
        ];
    }

    private function loadSupplementalFiles(){
        $aviary_posts = new \WP_Query(array(
            'post_type' => 'aviary-cpt',
            'posts_per_page' => -1, // Retrieve all posts
            'ignore_sticky_posts' => 1,
        ));

        if ($aviary_posts->have_posts()) {
            while ($aviary_posts->have_posts()) {
                $aviary_posts->the_post();

                $aviary_resource_id = get_field('aviary_resource_id', get_the_ID());
                $aviary_supplement_id = get_field('aviary_supplement_id', get_the_ID());
                $landing_page_link = get_field('landing_page_link', get_the_ID());
                $pdf_hyper_link = get_field('pdf_hyper_link', get_the_ID());

                $ids = [];
                if(is_array($aviary_supplement_id)){
                    foreach($aviary_supplement_id as $item){
                        $ids[] = $item['supplement_id'];
                    }
                }

                $this->supplementalFiles[$aviary_resource_id] = [
                    'supplemental_files' => $ids,
                    'page_link' => $landing_page_link,
                    'pdf_link' => $pdf_hyper_link
                ];
            }

            wp_reset_postdata();
        }
    }

    public static function query(){
        return new AviaryApi();
    }

    public function listCollections(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.aviaryplatform.com/api/v1/collections');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response,true)['data'];
    }

    public function listResources($collectionId){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.aviaryplatform.com/api/v1/collections/'.$collectionId.'/resources');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response,true)['data'];
    }

    public function getMedia($id){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.aviaryplatform.com/api/v1/media_files/'.$id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $response = curl_exec($ch);
        curl_close($ch);

        $media = json_decode($response,true)['data'];

        return [
            'thumbnail_url' => $media['thumbnail_url'] ?? "",
            'video_url' => $media['media_download_url'] ?? ""
        ];
    }

    public function getSupplementalFile($id){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.aviaryplatform.com/api/v1/supplemental_files/'.$id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $response = curl_exec($ch);
        curl_close($ch);

        $file = json_decode($response,true)['data'];

        return $file['file'];
    }

    public function getResource($resourceId){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.aviaryplatform.com/api/v1/resources/'.$resourceId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $response = curl_exec($ch);
        curl_close($ch);

        $resource = json_decode($response,true)['data'];
        $meta = [];

        foreach($resource['metadata'] as $metadata){
            $key = str_replace(" ", "_", strtolower(trim($metadata['label'])));
            $meta[$key] = $metadata['data'];
        }

        $resource2 = [
            'id'                        => $resource['id'],
            'title'                     => $resource['title'],
            'custom_unique_identifier'  => $resource['custom_unique_identifier'],
            'access_level'              => $resource['access'] ?? '',
            'description'               => $meta['interview_summary'][0]['value'] ?? [],
            'identity_marker'           => '',
            'refer_as'                  => '',
            'post_production'           => '',
            'public_housing_complexes'  => $meta['public_housing_connection(s)'] ?? '',
            'themes'                    => $meta['overarching_themes'] ?? '',
            'primary_locations'         => $meta['recording_location(s)'] ?? '',
            'coverage'                  => $meta['coverage'] ?? '',
            'primary_time_period'       => '',
            'content_warnings'          => $meta['content_warnings'] ?? '',
            'keywords'                  => $meta['keywords'] ?? '',
            'language'                  => $meta['language'] ?? '',
            'rights_statement'          => $meta['rights_statement'][0]['value'] ?? '',
            'biographical_context'      => $meta['biographical_context'][0]['value'] ?? '',
            'audio_quality_notes'       => $meta['audio_quality_notes'][0]['value'] ?? '',
            'interview_duration'        => $meta['interview_duration'] ?? '',
            'recording_location'        => $meta['recording_location'][0]['value'] ?? '',
            'self_identified_race'      => $meta['self-identified_race/ethnicity'][0]['value'] ?? '',
            'public_housing_connection' => $meta['public_housing_connection'] ?? '',
            'life_dates'                => $meta['life_dates'] ?? '',
            'interview_date'            => $meta['interview_date'] ?? '',
            'format'                    => $meta['format'] ?? '',
            'preferred_citation'        => $meta['preferred_citation'] ?? '',
            'method_of_interview'       => $meta['method_of_interview'] ?? '',
            'interviewer'               => $meta['oral_historians'] ?? '',
        ];

        if(isset($meta['oral_historians'])){
            foreach($meta['oral_historians'] as $value){
                if($value['vocabulary'] === 'Post-Production by') {
                    $resource2['post_production'] = $value['value'];
                }
            }
        }

        if(isset($meta['coverage'])){
            foreach($meta['coverage'] as $coverage){
                if($coverage['vocabulary'] === 'temporal (time periods)'){
                    $resource2['primary_time_period'] = $coverage['value'];
                }
            }
        }

        if(isset($meta['narrator(s)'])){
            foreach($meta['narrator(s)'] as $narrator){
                if($narrator['vocabulary'] === 'Pronouns'){
                    $resource2['identity_marker'] = $narrator['value'];
                }

                if($narrator['vocabulary'] === 'Refer to as'){
                    $resource2['refer_as'] = $narrator['value'];
                }
            }
        }

        $medias = [];
        foreach($resource['media_file_id'] as $mediaId){
            $media = $this->getMedia($mediaId);
            $medias[] = $media;
        }

        $resource2['media_files'] = $medias;

        if(isset($this->supplementalFiles[$resourceId])){
            $pageMeta = $this->supplementalFiles[$resourceId];
            $supplementalFiles = [];
            foreach($pageMeta['supplemental_files'] as $id){
                $supplementalFiles[] = $this->getSupplementalFile($id);
            }
            $pageMeta['supplemental_files'] = $supplementalFiles;
            $resource2['page_meta'] = $pageMeta;
        }

        return $resource2;
    }

    public function paginateResources($page = 1, $limit = 5){

        $allResources = [];

        $collections = $this->listCollections();
        foreach($collections as $collection){
            $resources = $this->listResources($collection['id']);
            foreach($resources as $resource){
                if(isset($resource['resource_id'])){
                    $resource = $this->getResource($resource['resource_id']);
                    if($resource !== false){
                        $allResources[] = $resource;
                    }
                }
            }
        }

        $paginator = new \stdClass();
        $paginator->total_items = count($allResources);
        $paginator->current_page = $page;
        $paginator->per_page = $limit;
        $paginator->last_page = ceil($paginator->total_items / $paginator->per_page);
        if($limit === -1) {
            $paginator->items = $allResources;
        }else{
            $paginator->items = array_slice($allResources, ($page - 1) * $limit, $limit);
        }

        return $paginator;
    }

    public function listRelatedResources($resource){

        $links = [];
        $allTags = [];

        $aviary_posts = new WP_Query(array(
            'post_type'             => 'aviary-cpt',
            'posts_per_page'        => -1,
            'ignore_sticky_posts'   => 1,
        ));

        if ($aviary_posts->have_posts()) {
            while ($aviary_posts->have_posts()) {
                $aviary_posts->the_post();

                $aviary_resource_id = get_field('aviary_resource_id', get_the_ID());
                $aviary_supplement_id = get_field('aviary_supplement_id', get_the_ID());
                $landing_page_link = get_field('landing_page_link', get_the_ID());
                $tags = get_the_terms(get_the_ID(),'aviary-resource-tag');
                $links[$aviary_resource_id] = $landing_page_link;
                $allTags[$aviary_resource_id] = $tags;
            }
            wp_reset_postdata();
        }

        $currentPostTags = $allTags[$resource['id']] ?? [];

        if( is_array($currentPostTags) ) {
            $currentPostTags = array_map(function($tag){
                return $tag->term_id;
            },$currentPostTags);
        }

        $relatedIds = [];

        if( isset($currentPostTags) && !empty( $currentPostTags ) ) {
            foreach($allTags as $id=>$values){
                foreach($values as $value){
                    if(in_array($value->term_id, $currentPostTags)){
                        if($id !== $resource['id']){
                            $relatedIds[] = $id;
                        }
                        break 1;
                    }
                }
            }
        }

        $relatedIds = array_slice($relatedIds, 0, 3);

        $relatedResources = [];
        foreach($relatedIds as $resourceId){
            $relatedResources[] = $this->getResource($resourceId);
        }

        return $relatedResources;
    }
}
