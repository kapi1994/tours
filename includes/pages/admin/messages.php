<?php 
    if(!isset($_SESSION['user']) || isset($_SESSION['user']) && $_SESSION['user']->role_id != 1)
        header("Content-type:application/json");
    $messages = getAllMessages();
    $messagePage = messagePagination();
?>
<main>
    <section class="container">
        <div class="row mt-5">
            <div class="mt-5" id="message_response_message"></div>
            <div class="col">
                <div class="table-responsive-sm table-responsive-md">
                    <table class="table text-center align-middle">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Full name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Arrived at</th>
                                <th scope="col">Read</th>
                            </tr>
                        </thead>
                        <tbody id="messages">
                            <?php foreach($messages as $index=>$message):?>
                            <tr id="message_<?=$index?>">
                                <th scope="row"><?=$index + 1?></th>
                                <td><?=$message->first_name.' '.$message->last_name?></td>
                                <td><?=$message->email?></td>
                                <td><?=date('d/m/Y H:i:s', strtotime($message->created_at))?></td>
                                <td>
                                <button type="button" class="btn btn-primary btn-sm btn-read-message" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?=$message->id?>">Read</button>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-2">
                <nav aria-label="Page navigation example">
                    <ul class="pagination" id="message-pages">
                        <?php for($i = 0; $i < $messagePage; $i++):?>
                        <li class="page-item"><a class="message-page page-link <?=$i==0 ? 'active' : ''?>" href="#" data-limit = "<?=$i?>"><?=$i+1?></a></li>
                        <?php endfor?>
                    </ul>
                </nav>
                </div>
            </div>
        </div>
    </section>
</main>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Message</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <p class="mb-2">
                <span class="fw-bold">User from:</span> <span id="user-from"></span>
            </p>
            <div class="d-flex gap-2 mb-2 text-muted">
                <span class="fw-bold">From</span>: <span id="email-from"></span>
            </div>
            <p>
                <span class="fw-bold">Arrived at:</span>
                <span id="arrived_at"></span>
            </p>
            <p id="message"></p>
      </div>
    </div>
  </div>
</div>